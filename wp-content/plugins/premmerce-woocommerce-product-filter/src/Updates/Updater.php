<?php

namespace Premmerce\Filter\Updates;

use  Premmerce\Filter\FilterPlugin ;
use  Premmerce\Filter\Seo\SeoModel ;
use  Premmerce\Filter\Seo\SeoTermModel ;
class Updater
{
    const  DB_OPTION = 'premmerce_filter_db_version' ;
    public function checkForUpdates()
    {
        return $this->compare( FilterPlugin::VERSION );
    }
    
    private function compare( $version )
    {
        $dbVersion = get_option( self::DB_OPTION, '1.1' );
        return version_compare( $dbVersion, $version, '<' );
    }
    
    public function update()
    {
        
        if ( $this->checkForUpdates() ) {
            $this->installDb();
            foreach ( $this->getUpdates() as $version => $callback ) {
                if ( $this->compare( $version ) ) {
                    call_user_func( $callback );
                }
            }
        }
    
    }
    
    public function installDb()
    {
    }
    
    public function getUpdates()
    {
        return array(
            '2.0' => array( $this, 'update2_0' ),
            '3.1' => array( $this, 'update3_1' ),
        );
    }
    
    public function update2_0()
    {
        update_option( self::DB_OPTION, '2.0' );
    }
    
    public function update3_1()
    {
        $settings = get_option( 'premmerce_filter_settings' );
        $settings['taxonomies'] = FilterPlugin::DEFAULT_TAXONOMIES;
        $settings['style'] = 'premmerce';
        $settings['ajax_strategy'] = 'woocommerce_content';
        update_option( 'premmerce_filter_settings', $settings );
        update_option( self::DB_OPTION, FilterPlugin::VERSION );
    }

}