<?php
/*
Plugin Name: SMSPILOT.RU WooCommerce
Description: SMS уведомления о заказах WooCommerce через шлюз SMSPILOT.RU
Version: 1.31
Author: SMSPILOT.RU
Author URI: https://smspilot.ru
Plugin URI: https://smspilot.ru/woocommerce.php
*/
if (!is_callable('is_plugin_active')) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
if (is_plugin_active('woocommerce/woocommerce.php')) {
	add_action('plugins_loaded', 'smspilot_woocommerce::load');
}

register_activation_hook( __FILE__, 'smspilot_woocommerce::activate' );

// smspilot_send( '79087964781', 'test');
function smspilot_send( $phone, $message )
{
	$s = new smspilot_woocommerce();
	return $s->send( $phone, $message );

}


class smspilot_woocommerce {

	public static function load() {
		$_this = new self();
		add_action( 'admin_menu', array($_this,'admin_menu'));
		add_action( 'woocommerce_new_order', array($_this,'status_changed'),  10, 1  );
		add_action( 'woocommerce_order_status_changed', array($_this, 'status_changed'), 10, 3);
		return $_this;
	}


	public static function activate()
	{
		register_uninstall_hook( __FILE__, 'smspilot_woocommerce::uninstall' );
	}

	public static function uninstall() {

	    delete_option('smspilot_apikey');
	    delete_option('smspilot_sender');
	    delete_option('smspilot_vendor_phone');
		delete_option('smspilot_vendor_status1');
	    delete_option('smspilot_vendor_msg1');
	    delete_option('smspilot_vendor_status2');
		delete_option('smspilot_vendor_msg2');
		delete_option('smspilot_shopper_status1');
		delete_option('smspilot_shopper_msg1');
		delete_option('smspilot_shopper_status2');
		delete_option('smspilot_shopper_msg2');
		delete_option('smspilot_last_error');
	}
	
	public function admin_menu() {
		add_submenu_page('woocommerce', 'SMS оповещения о заказах через SMSPILOT.RU', 'SMSPILOT.RU', 'manage_woocommerce', 'smspilot_settings', array(&$this,'options'));
	}
	private function params()
	{
		return array(
			'apikey' => get_option('smspilot_apikey'),
			'sender' => get_option('smspilot_sender'),
			'vendor_phone' => get_option('smspilot_vendor_phone'),
			'vendor_status1' => get_option('smspilot_vendor_status1','processing'),
			'vendor_msg1' => get_option('smspilot_vendor_msg1', 'Поступил заказ на сумму {SUM}. Номер заказа {NUM}'),
			'vendor_status2' => get_option('smspilot_vendor_status2','cancelled,failed'),
			'vendor_msg2' => get_option('smspilot_vendor_msg2','Статус заказа изменился на {NEW_STATUS}. Номер заказа {NUM}'),
			'shopper_status1' => get_option('smspilot_shopper_status1', 'processing'),
			'shopper_msg1' => get_option('smspilot_shopper_msg1','Ваш заказ на сумму {SUM} принят. Номер заказа {NUM}'),
			'shopper_status2' => get_option('smspilot_shopper_status2','completed'),
			'shopper_msg2' => get_option('smspilot_shopper_msg2','Статус вашего заказа изменился на {NEW_STATUS}. Номер заказа {NUM}')
		);
	}
	public function options() {

		$p = $this->params();

		if ( isset($_POST['apikey']) ) {
			foreach( $p as $k => $vv ) {
				$v = '';
				if (isset($_POST[$k])) {
					if ( is_string($_POST[$k]) ) {
						$v = $_POST[ $k ];
					} else if ( is_array($_POST[$k]) ) {
						$v = implode(',', $_POST[$k]);
					}
				}
				update_option('smspilot_' . $k, $v);
			}

			if ( isset($_POST['test']) ) {
				$data = array(
					'%s' => '1234.56',
					'%n' => '7890',
					'{SUM}' => '1234.56',
					'{FSUM}' => '1234.56 руб.',
					'{NUM}' => '7890',
					'{ITEMS}' => 'Название товара: 2x150=300',
					'{EMAIL}' => 'pokupatel@mail.ru',
					'{PHONE}' => '+79000000000',
					'{FIRSTNAME}' => 'Сергей',
					'{LASTNAME}' => 'Смирнов',
					'{CITY}' => 'г. Омск',
					'{ADDRESS}' => 'ул. Ленина, д. 1, кв. 2',
					'{BLOGNAME}' => get_bloginfo('name'),
					'{OLD_STATUS}' => 'Обработка',
					'{NEW_STATUS}' => 'Выполнен',
					'{COMMENT}' => 'Код домофона 123, после обеда',
					'{' => '*',
					'}' => '*',
				);
				$message = str_replace( array_keys($data), array_values($data), $_POST['vendor_msg1'] );
				$r = $this->send( $_POST['vendor_phone'], $message );
				if ( is_numeric($r) ) {
					$test_result = '<p style="color: green">Сообщение: <code>'.$message.'</code> отправлено на '.$_POST['vendor_phone'].', код <a href="https://smspilot.ru/my-report.php?view=sms&search=['.$r.']" target="_blank" title="Отчет о доставке, откроется в новой вкладке">'.$r.'</a></p>';
				} else {
					$test_result = '<p style="color: red">Сообщение: <code>'.$message.'</code> НЕ отправлено на '.$_POST['vendor_phone'].', причина:<br/>'.$r.'</p>';
				}
			} else {
				wp_redirect(admin_url('admin.php?page=smspilot_settings&status=updated'));
			}
			$p = $this->params();
		}


		/* pending Order received (unpaid)
failed – Payment failed or was declined (unpaid). Note that this status may not show immediately and instead show as Pending until verified (i.e., PayPal)
processing – Payment received and stock has been reduced – the order is awaiting fulfillment. All product orders require processing, except those that are Digital and Downloadable.
completed – Order fulfilled and complete – requires no further action
on-hold – Awaiting payment – stock is reduced, but you need to confirm payment
cancelled – Cancelled by an admin or the customer – no further action required
refunded – Refunded by an admin – no further action required */

		if ( $p['apikey'] ) {
			$json = $this->_post('http://smspilot.ru/api.php', array('balance' => 'rur', 'format' => 'json', 'apikey' => $p['apikey']) );
			if ( $j = json_decode($json) ) {
				//print_r( $j );
				if ( isset($j->error) ) {
					$balance = '<em style="color: red">'.$j->error->description_ru.'</em>';
				} else {
					$balance = $j->balance.'&nbsp;&nbsp;|&nbsp;&nbsp;<a href="https://smspilot.ru/my-order.php" target="_blank">Пополнить баланс</a>';
				}
			} else {
				$balance = $json;
			}

		} else {
			$balance = '<span style="color: red">Нужно ввести API-ключ</span>';
		}
		$msg = array(
			array( 'SMS продавцу о новом заказе', 'vendor_status1', 'vendor_msg1' ),
			array( 'SMS продавцу о смене статуса', 'vendor_status2', 'vendor_msg2' ),
			array( 'SMS покупателю о подтверждении заказа', 'shopper_status1', 'shopper_msg1' ),
			array( 'SMS покупателю о смене статуса', 'shopper_status2', 'shopper_msg2' )
		);
?>
		<div class="wrap woocommerce">
			<form method="post" id="mainform" action="<?= admin_url('admin.php?page=smspilot_settings') ?>">
				<h2>SMS оповещения о заказах через SMSPILOT.RU</h2>
				<p><a href="https://smspilot.ru/my.php" target="_blank">Личный кабинет</a> | <a href="https://smspilot.ru/my-report.php" target="_blank">Отчеты о доставке</a></p>
				<?= !empty($test_result) ? $test_result : '' ?>
				<?= (isset($_GET['status']) && $_GET['status'] === 'updated' ) ? '<p style="color: green">Настройки обновлены</p>' : '' ?>
				<?= ( $last_e = get_option('smspilot_last_error')) ? '<p>Последняя ошибка:<br/>'.$last_e.'</p>' : '' ?>
				<table class="form-table">
					<tr><th><label for="apikey">API-ключ</label></th><td><input title="64-символьный ключ доступа к сайту SMSPILOT.RU" required name="apikey" id="apikey" value="<?= $p['apikey'] ?>" size="64" /><br/>
					<small>Замените API-ключ на свой,  <a href="https://smspilot.ru/my-settings.php" target="_blank">https://smspilot.ru/my-settings.php</a></small></td></tr>
					<tr><th><label>Баланс</label></th><td><?= $balance ?></td></tr>
					<tr><th><label for="sender">Имя отправителя</label></th><td><input name="sender" id="sender" value="<?= $p['sender'] ?>" /><br/>
					<small>Список доступных имен <a href="https://smspilot.ru/my-sender.php" target="_blank">https://smspilot.ru/my-sender.php</a>, можно оставить пустым.</small></td></tr>
					<tr><th><label for="vendor_phone">Телефон продавца</label></th><td><input required name="vendor_phone" id="vendor_phone" value="<?= $p['vendor_phone']  ?>" size="40" /><br/><small>Например, 79089876543, можно указать несколько через запятую.</small></td></tr>
					<tr><th><label>Шаблоны SMS</label></th><td><p>Если меняете текст здесь, то добавьте нужный <a href="https://smspilot.ru/my-template.php" target="_blank" title="Откроется в новой вкладке">шаблон в личном кабинете SMSPILOT.RU</a>.<br/>Бизнес-клиентам сервиса это делать не обязательно..</p>
						</td></tr>
					<?php foreach( $msg as $m) { ?>
					<tr><th><label for="<?= $m[2] ?>"><?= $m[0] ?></label></th><td>
					Статус: <?= $this->_checkboxes( $m[1], $p[ $m[1] ] ) ?><br/>
					Текст: <input name="<?= $m[2] ?>" id="<?= $m[2] ?>" value="<?= $p[ $m[2] ]  ?>" size="80" />
					</td>
					</tr>
					<?php } ?>
					<tr><th><label>Можно вставить</label></th><td>
						<pre><code>{NUM} - номер заказа, {FNUM} - №номерзаказа, {SUM} - сумма заказа, {FSUM} - суммазаказа руб., {EMAIL} - эл.почта покупателя,
{PHONE} - телефон покупателя, {FIRSTNAME} - имя покупателя, {LASTNAME} - фамилия покупателя,
{CITY} - город доставки, {ADDRESS} - адрес доставки, {BLOGNAME} - название блога/магазина,
{OLD_STATUS} - старый статус, {NEW_STATUS} - новый статус, {ITEMS} - список заказанных товаров
{COMMENT} - комментарий покупателя к заказу
<strong>{Произвольное поле}</strong> - вставка значения произвольного поля, которое вы или плагины добавили к заказу, например, {post_tracking_number} или {ems_tracking_number} если установлен плагин <a href="https://ru.wordpress.org/plugins/russian-post-and-ems-for-woocommerce/" target="_blank">Почта России и EMS для WooCommerce</a> . Чувствительно к регистру символов!</code></pre></td></tr>
				</table>
				<br>
				<input type="submit" class="button-primary" value="Сохранить">&nbsp;&nbsp;
				<input type="submit" class="button-secondary" name="test" value="Сохранить и отправить тестовую SMS на телефон продавца" />
			</form>
		</div>
<?php
	}
	private function _checkboxes( $name, $selected )
	{
		$selected = explode(',',$selected);

		$r = '';
		foreach( wc_get_order_statuses() as $k => $v ) {
			$k = substr( $k, 3 );
			$r .= '<label><input type="checkbox" name="'.$name.'[]"'.( in_array( $k, $selected, true ) ? ' checked="checked"' : '').' value="'.$k.'" /> '.$v.'</label>&nbsp;&nbsp;';
		}
		return $r;
	}

	public function status_changed($order_id, $old_status = 'pending', $new_status = 'pending')
	{

		$p = $this->params();

		if ( $p['apikey'] ) {

			$o = new WC_Order($order_id);

			// new order to admin
			if ( strpos($p['vendor_status1'], $new_status) !== false ) {
				$this->_send( $p['vendor_phone'], $p['vendor_msg1'], $o, $old_status, $new_status );
			}
			// new status to admin
			if ( strpos($p['vendor_status2'], $new_status) !== false ) {
				$this->_send( $p['vendor_phone'], $p['vendor_msg2'], $o, $old_status, $new_status );
			}
			// confirmed order to shopper
			if ( strpos($p['shopper_status1'], $new_status) !== false ) {
//				$this->_send( $o->billing_phone, $p['shopper_msg1'], $o, $old_status, $new_status );
				$this->_send( $o->get_billing_phone(), $p['shopper_msg1'], $o, $old_status, $new_status );
			}
			// change status to shopper
			if ( strpos($p['shopper_status2'], $new_status) !== false ) {
//				$this->_send( $o->billing_phone, $p['shopper_msg2'], $o, $old_status, $new_status );
				$this->_send( $o->get_billing_phone(), $p['shopper_msg2'], $o, $old_status, $new_status );
			}
		}
	}

	/**
	 * @param $phone
	 * @param $message
	 * @param $order WC_Order
	 * @param $old_status
	 * @param $new_status
	 *
	 * @return bool|int
	 */
	private function _send($phone, $message, $order, $old_status, $new_status ) {
		if ( ! $phone || ! $message ) {
			return false;
		}

//		file_put_contents( __FILE__.'.log', print_r( $order, true) );

		$search  = array(
			'{NUM}',
			'{FNUM}',
			'{SUM}',
			'{FSUM}',
			'{EMAIL}',
			'{PHONE}',
			'{FIRSTNAME}',
			'{LASTNAME}',
			'{CITY}',
			'{ADDRESS}',
			'{BLOGNAME}',
			'{OLD_STATUS}',
			'{NEW_STATUS}',
			'{COMMENT}'
		);
		$replace = array(
			$order->get_order_number(),
			'№' . $order->get_order_number(),
			$order->get_total(),
			strip_tags( $order->get_formatted_order_total( false, false ) ),
			$order->get_billing_email(),
			$order->get_billing_phone(),
			($s = $order->get_shipping_first_name()) ? $s : $order->get_billing_first_name(),
			($s = $order->get_shipping_last_name()) ? $s : $order->get_billing_last_name(),
			($s = $order->get_shipping_city()) ? $s : $order->get_shipping_city(),
			trim(
				(($s = $order->get_shipping_address_1()) ? $s : $order->get_billing_address_1())
				.' '
				.(($s = $order->get_shipping_address_2()) ? $s : $order->get_billing_address_2())
			),
			get_option( 'blogname' ),
			wc_get_order_status_name( $old_status ),
			wc_get_order_status_name( $new_status ),
			$order->get_customer_note()
		);
		if ( strpos( $message, '{ITEMS}' ) !== false ) {

			$items     = $order->get_items( 'line_item' );
			$items_str = '';
			foreach ( $items as $i ) {
//				if ( ( $_p = $order->get_product_from_item( $i ) ) && ( $sku = $_p->get_sku() ) ) {
				/* @var $i WC_Order_Item_Product */
				if ( ( $_p = $i->get_product() ) && ( $sku = $_p->get_sku() ) ) {
					$i['name'] = $sku . ' ' . $i['name'];
				}
				$items_str .= "\n" . $i['name'] . ': ' . $i['qty'] . 'x' . $order->get_item_total( $i ) . '=' . $order->get_line_total( $i );
			}
			$sh = $order->get_shipping_methods();
			foreach ( $sh as $i ) {
				$items_str .= "\n" . __( 'Shipping', 'woocommerce' ) . ': ' . $i['name'] . '=' . $i['cost'];
			}
			$items_str .= "\n";

			$search[]  = '{ITEMS}';
			$replace[] = strip_tags( $items_str );
		}

		if ( $meta = get_post_meta( $order->get_id() ) ) {
			foreach( $meta as $k => $v ) {
				$search[] = '{'.$k.'}';
				$replace[] = $v[0];
			}
		}


		foreach ( $replace as $k => $v ) {
			$replace[ $k ] = html_entity_decode( $v );
		}
		$message = str_replace( $search, $replace, $message );
		$message = preg_replace('/\s?\{[^}]+\}/','', $message ); // remove unknown {VAR}
		$message = trim( $message );
		$message = mb_substr( $message, 0, 670 );

		return $this->send( $phone, $message );

	}
	public function send( $phone, $message ) {
		if (!$phone || !$message) {
			return false;
		}
		$json = $this->_post( 'http://smspilot.ru/api.php', array(
			'send' => $message,
			'to' => $phone,
			'from' => get_option('smspilot_sender'),
			'apikey' => get_option('smspilot_apikey'),
			'source_id' => 8,
			'format' => 'json'
		));
		if ( $json && ( $j = json_decode($json) ) ) {
			if (isset($j->error)) {
				update_option('smspilot_last_error', gmdate('Y-m-d H:i:s').' - '.$phone.':'.$message.' - '.$j->error->description_ru);
				return false;
			}
			return (int) $j->send[0]->server_id;
		}
		return false;
	}
	// sockets version HTTP/POST
	private function _post( $url, $data ) {

		$eol = "\r\n";

		$post = '';

		if (is_array($data)) {
			foreach( $data as $k => $v) {
				$post .= $k . '=' . urlencode($v) . '&';
			}
			$post = substr($post,0,-1);
			$content_type = 'application/x-www-form-urlencoded';
		} else {
			$post = $data;
			$content_type = 'text/html';
			if (strpos($post, '<?xml') === 0) {
				$content_type = 'text/xml';
			} else if (strpos($post, '{') === 0) {
				$content_type = 'application/json';
			}
		}

		if (function_exists('curl_init')) {
			$ch = curl_init( $url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: '.$content_type ) );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
			$r = curl_exec($ch);
			if ($r) {
				return $r;
			}
			trigger_error( curl_error($ch) );
			return false;
		}

		if ((($u = parse_url($url)) === false) || !isset($u['host'])) { return false; }

		if (!isset($u['scheme'])) { $u['scheme'] = 'http'; }

		$request = 'POST '.(isset($u['path']) ? $u['path'] : '/').( isset($u['query']) ? '?'.$u['query'] : '' ).' HTTP/1.1'.$eol
			.'Host: '.$u['host'].$eol
			.'Content-Type: '.$content_type.$eol
			.'Content-Length: '.mb_strlen($post, 'latin1').$eol
			.'Connection: close'.$eol.$eol
			.$post;

		$host = ($u['scheme'] === 'https') ? 'ssl://'.$u['host'] : $u['host'];
		$port = ($u['scheme'] === 'https') ? 443 : 80;
		if (isset($u['port'])) {
			$port = $u['port'];
		}

		$fp = @fsockopen( $host, $port, $errno, $errstr, 10);
		if ($fp) {

			$content = '';
			$content_length = false;
			$chunked = false;

			fwrite($fp, $request);

			// read headers
			while ($line = fgets($fp)) {
				if ( preg_match('/^HTTP\/[\S]*\s(.*?)\s/',$line, $m) && (int) $m[1] !== 200 ) {
					fclose($fp);
					return false;
				}
				if (preg_match('~Content-Length: (\d+)~i', $line, $matches)) {
					$content_length = (int) $matches[1];
				} else if (preg_match('~Transfer-Encoding: chunked~i', $line)) {
					$chunked = true;
				} else if ($line === "\r\n") {
					break;
				}

			}
			// read content
			if ($content_length !== false) {

				$_size = 4096;
				do {
					$_data = fread($fp, $_size );
					$content .= $_data;
					$_size = min($content_length-strlen($content), 4096);
				} while( $_size > 0 );

			} else if ($chunked) {

				while ( $chunk_length = hexdec(trim(fgets($fp))) ) {

					$chunk = '';
					$read_length = 0;

					while ( $read_length < $chunk_length ) {

						$chunk .= fread($fp, $chunk_length - $read_length);
						$read_length = strlen($chunk);

					}
					$content .= $chunk;

					fgets($fp);

				}
			} else {
				while(!feof($fp)) { $content .= fread($fp, 4096); }
			}
			fclose($fp);

//		echo $content;

			return $content;

		}
		return false;
	}
}