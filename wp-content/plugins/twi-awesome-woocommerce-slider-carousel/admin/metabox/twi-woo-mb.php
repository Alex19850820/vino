<?php
return array(
 'id'          => 'twi_woo_mb_main',
 'types'       => array('twi_woo_g_car'),
 'title'       => __('Woocommerce Grid/Slider/Carousel', 'twi_awesome_woo_slider_carousel'),
 'priority'    => 'high',
 'is_dev_mode' => false,
 'template'    => array(
 	                array(
						'name'    => 'pro_dis_style',
						'type'    => 'radiobutton',
						'label'   => __('Product Display', 'twi_awesome_woo_slider_carousel'),
								'items'   => array(
									'data' => array(
										array(
											'source' => 'function',
											'value'  => 'woo_sl_grid_pro_dis_style',
									    ),
								    ),
						        ),
						'default' => array('cat_wise'),
					),

					array(
						'name'    => 'cat_type',
						'type'    => 'radiobutton',
						'dependency' => array(
							'field' => 'pro_dis_style',
							'function' => 'woo_cat_type_dep',
						),
						'label'   => __('Showcase Type', 'twi_awesome_woo_slider_carousel'),
								'items'   => array(
									'data' => array(
										array(
											'source' => 'function',
											'value'  => 'woo_cat_type',
									    ),
								    ),
						        ),
						'default' => array('cat_type'),
					),

					array(
						'name'    => 'sub_cat_dis',
						'type'    => 'select',
						'dependency' => array(
							'field' => 'cat_type,pro_dis_style',
							'function' => 'sub_cat_type_dep',
						),
						'label'   => __('Select Category', 'twi_awesome_woo_slider_carousel'),
								'items'   => array(
									'data' => array(
										array(
											'source' => 'function',
											'value'  => 'twi_woo_get_categories',
									    ),
								    ),
						),
					),

					array(
						'name'    => 'cat',
						'type'    => 'multiselect',
						'dependency' => array(
							'field' => 'pro_dis_style',
							'function' => 'cat_wise_dep',
						),
						'label'   => __('Select Categories,if you want to show all categories,plase leave it blank.', 'twi_awesome_woo_slider_carousel'),
								'items'   => array(
									'data' => array(
										array(
											'source' => 'function',
											'value'  => 'twi_get_categories',
									    ),
								    ),
						),
					),

					array(
						'name'    => 'spe_pro',
						'type'    => 'multiselect',
						'dependency' => array(
							'field' => 'pro_dis_style',
							'function' => 'spe_pro_dep',
						),
						'label'   => __('Select Specific Products', 'twi_awesome_woo_slider_carousel'),
								'items'   => array(
									'data' => array(
										array(
											'source' => 'function',
											'value'  => 'twi_get_pro_list',
									    ),
								    ),
						),
					),
                          
                    array(
						'type'    => 'slider',
						'name'    => 'per_page',
						'label'   => __('Show per page', 'twi_awesome_woo_slider_carousel'),
						'min'     => '1',
						'max'     => '100',
						'default' => '10'
					),

 	      			 array(
							'type' => 'radiobutton',
							'name' => 'twi_woo_g_c_style',
							'label' => __('Your Style', 'twi_awesome_woo_slider_carousel'),
							'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value'  => 'woo_sl_grid_styles',
											),
										),							
									),
							'default' => array('twi_woo_grid'),
						),

 	      			 array(
							'type' => 'select',
							'name' => 'row_count',
							'dependency' => array(
								'field' => 'twi_woo_g_c_style',
								'function' => 'twi_woo_car_gap',
							),
							'label' => __('Row Count', 'twi_awesome_woo_slider_carousel'),
							'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value'  => 'woo_slider_row',
											),
										),							
									),
							'default' => array('1'),
						),

 	      			   array(
							'type' => 'slider',
							'name' => 'items_gap',
							'dependency' => array(
								'field' => 'twi_woo_g_c_style',
								'function' => 'twi_woo_car_gap',
							),
							'label' => __('Items Between Gap', 'twi_awesome_woo_slider_carousel'),
							'min' => '0',
							'max' => '200',
							'step' => '1',
							'default' => '10',
						),

 	      			    array(
								'type'    => 'slider',
								'dependency' => array(
									'field' => 'twi_woo_g_c_style',
									'function' => 'twi_woo_gutter',
								),
								'name'    => 'woo_gutter',
								'label'   => __('Gap Between Grids (px)', 'twi_awesome_woo_slider_carousel'),
								'min'     => '0',
								'max'     => '200',
								'default' => '10'
					    ),

                                            array(
												'type' => 'radiobutton',
												'dependency' => array(
														'field' => 'twi_woo_g_c_style',
														'function' => 'twi_woo_gap',
												),
												'name' => 'twi_woo_grid_gap',
												'label' => __('Gap Between Grids', 'twi_awesome_woo_slider_carousel'),
												'items' => array(
															'data' => array(
																array(
																	'source' => 'function',
																	'value'  => 'woo_sl_grid_gap',
																),
															),								
														),
												'default' => array('normal'),
											    ),

 	      			 array(
							    'type' => 'group',
							    'repeating' => false,
							    'length' => 1,
							    'name' => 'twi_woo_grid_group',
							    'title' => __('Grid Settings', 'twi_awesome_woo_slider_carousel'),
							    'dependency' => array(
										'field' => 'twi_woo_g_c_style',
										'function' => 'twi_woo_st_dep_grid',
								),
							    'fields' => array(
									    array(
											'type' => 'select',
											'name' => 'twi_woo_grid_desktop_big',
											'label' => __('Large Desktops', 'twi_awesome_woo_slider_carousel'),
											'description' => __('Xlarge (1200px and larger)','twi_awesome_woo_slider_carousel'),
											'items' => array(
															'data' => array(
																array(
																	'source' => 'function',
																	'value'  => 'woo_sl_grid_no',
																),
															),							
														),
											'default' => array('4'),
										    ),
                                            
                                            array(
											'type' => 'select',
											'name' => 'twi_woo_grid_desktop',
											'label' => __('Desktops & tablets landscape', 'twi_awesome_woo_slider_carousel'),
											'description' => __('Large (960px to 1199px)','twi_awesome_woo_slider_carousel'),
											'items' => array(
															'data' => array(
																array(
																	'source' => 'function',
																	'value'  => 'woo_sl_grid_no',
																),
															),						
														),
											'default' => array('4'),
										    ),
       

                                         array(
											'type' => 'select',
											'name' => 'twi_woo_grid_tablet',
											'label' => __('Tablets portrait', 'twi_awesome_woo_slider_carousel'),
											'description' => __('Medium (768px to 959px)','twi_awesome_woo_slider_carousel'),
											'items' => array(
															'data' => array(
																array(
																	'source' => 'function',
																	'value'  => 'woo_sl_grid_no',
																),
															),							
														),
											'default' => array('3'),
										    ),

                                            array(
											'type' => 'select',
											'name' => 'twi_woo_grid_phone_big',
											'label' => __('Phones landscape', 'twi_awesome_woo_slider_carousel'),
											'description' => __('Small (480px to 767px)','twi_awesome_woo_slider_carousel'),
											'items' => array(
															'data' => array(
																array(
																	'source' => 'function',
																	'value'  => 'woo_sl_grid_no',
																),
															),							
														),
											'default' => array('2'),
										    ),
                                            
                                            array(
											'type' => 'select',
											'name' => 'twi_woo_grid_phone',
											'label' => __('Phones portrait', 'twi_awesome_woo_slider_carousel'),
											'description' => __('Mini (up to 479px)','twi_awesome_woo_slider_carousel'),
											'items' => array(
															'data' => array(
																array(
																	'source' => 'function',
																	'value'  => 'woo_sl_grid_no',
																),
															),						
														),
											'default' => array('1'),
										    ),
                                          
                                           array(
											'type' => 'radiobutton',
											'name' => 'pagination',
											'label' => __('Pagination', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												            'data' => array(
																array(
																	'source' => 'function',
																	'value'  => 'woo_sl_grid_yes_no',
																),
															),				
														),
											'default' => array('yes'),
										    ),

                                           array(
											'type' => 'radiobutton',
											'name' => 'pagi_type',
											'dependency' => array(
													'field' => 'pagination',
													'function' => 'pagi_type_fun',
											),
											'label' => __('Pagination Type', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												            'data' => array(
																array(
																	'source' => 'function',
																	'value'  => 'woo_pagination_type',
																),
															),				
														),
											'default' => array('nor_page'),
										    ),

                                           array(
										    'type'      => 'group',
										    'repeating' => false,
										    'length'    => 1,
										    'name'      => 'grid_pagi_settings',
										    'dependency' => array(
													'field' => 'pagination,pagi_type',
													'function' => 'pagi_show_fun',
											),
										    'title'     => __('Pagination Style', 'twi_awesome_woo_slider_carousel'),
										    'fields'    => array(
										    	     array(
														'type' => 'html',
														'name' => 'grid_pagi_preview',	                        
														'binding' => array(
														'field' => 'grid_pagi_pos,text1,bg1,bor_col1,bor_width1,text2,bg2,bor_col2,bor_width2,bor_rad,pad',
														'function' => 'woo_grid_pagi_fun',
														),
													),
										    	   array(
														'type' => 'radiobutton',
														'name' => 'grid_pagi_pos',
														'label' => __('Pagination Position', 'twi_awesome_woo_slider_carousel'),
														'items' => array(
																		'data' => array(
																			array(
																				'source' => 'function',
																				'value'  => 'woo_sl_pagi_pos',
																			),
																		),						
																	),
														'default' => array('center'),
													),
										    	    array(
												        'type' => 'color',
												        'name' => 'text1',
												        'label' => __('Text Color', 'twi_awesome_woo_slider_carousel'),
												        'default' => '#000',
												    ),
												    array(
												        'type' => 'color',
												        'name' => 'bg1',
												        'label' => __('Background Color', 'twi_awesome_woo_slider_carousel'),
												        'default' => '#fff',
												    ),
												    array(
												        'type' => 'color',
												        'name' => 'bor_col1',
												        'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
												        'default' => '#000',
												    ),
												    array(
												    'type' => 'slider',
												        'name' => 'bor_width1',
												        'label' => __('Border Width', 'twi_awesome_woo_slider_carousel'),
												        'min' => '0',
												        'max' => '10',
												        'step' => '1',
												        'default' => '2',
												    ),
												    array(
												        'type' => 'color',
												        'name' => 'text2',
												        'label' => __('Text Color(Hover/Active)', 'twi_awesome_woo_slider_carousel'),
												        'default' => '#fff',
												    ),
												    array(
												        'type' => 'color',
												        'name' => 'bg2',
												        'label' => __('Background Color(Hover/Active)', 'twi_awesome_woo_slider_carousel'),
												        'default' => '#00a8e6',
												    ),
												    array(
												        'type' => 'color',
												        'name' => 'bor_col2',
												        'label' => __('Border Color(Hover/Active)', 'twi_awesome_woo_slider_carousel'),
												        'default' => '#00a8e6',
												    ),
												    array(
												    'type' => 'slider',
												        'name' => 'bor_width2',
												        'label' => __('Border Width(Hover/Active)', 'twi_awesome_woo_slider_carousel'),
												        'min' => '0',
												        'max' => '10',
												        'step' => '1',
												        'default' => '2',
												    ),
												    array(
                                                    'type' => 'slider',
												        'name' => 'bor_rad',
												        'label' => __('Border Radius(%)', 'twi_awesome_woo_slider_carousel'),
												        'min' => '0',
												        'max' => '50',
												        'step' => '1',
												        'default' => '10',
												    ),
												    array(
                                                    'type' => 'slider',
												        'name' => 'pad',
												        'label' => __('Padding', 'twi_awesome_woo_slider_carousel'),
												        'min' => '0',
												        'max' => '15',
												        'step' => '1',
												        'default' => '6',
												    ),
										       ),
										    ),

                                    
                                    array(
									    'type' => 'group',
									    'repeating' => false,
									    'length' => 1,
									    'name' => 'twi_load_more_group',
									    'title' => __('Load More/Infinite Load', 'twi_awesome_woo_slider_carousel'),
									    'dependency' => array(
											    'field' => 'pagination,pagi_type',
												'function' => 'load_more_pagi_fun',
										),
									    'fields' => array(

											    	    array(
													        'type' => 'textbox',
													        'name' => 'load_txt',
													        'label' => __('Load Text', 'twi_awesome_woo_slider_carousel'),
													        'default' => 'Load More',
													    ),

													    array(
													        'type' => 'textbox',
													        'name' => 'done_txt',
													        'label' => __('Done Text', 'twi_awesome_woo_slider_carousel'),
													        'default' => 'No More Products',
													    ),

													    array(
													        'type' => 'upload',
													        'name' => 'up_loader',
													        'label' => __('Upload Loader Animated Image', 'twi_awesome_woo_slider_carousel'),
													        'default' => TWI_AWESOME_WOO_SLIDER_CAROUSEL_URL.'/images/preloader.gif',
													    ),
									    ),
									),


									array(
									    'type' => 'group',
									    'repeating' => false,
									    'length' => 1,
									    'name' => 'twi_woo_click_load_more',
									    'title' => __('Load More Live Preview', 'twi_awesome_woo_slider_carousel'),
									    'dependency' => array(
											'field' => 'pagination,pagi_type',
										    'function' => 'click_more_pre_dep',
										),
									    'fields' => array(

									    	            array(
															'type' => 'html',
															'name' => 'click_bu_pre',
															'binding' => array(
																'field' => 'font,style,weight,cl_bg,cl_bg_ho,cl_bor_wid,cl_bor_col,cl_bor_col_ho,cl_bor_rad',
																'function' => 'twi_woo_click_bu',
															),
														),

									    	            array(
															'type' => 'select',
															'name' => 'font',
															'label' => __('Font Face', 'twi_awesome_woo_slider_carousel'),
															'description' => __('<b>Default:</b> Roboto', 'twi_awesome_woo_slider_carousel'),
															'items' => array(
																		'data' => array(
																			array(
																				'source' => 'function',
																				'value' => 'vp_get_gwf_family',
																			),
																		),
																	),
																	'default' => array(
																		'Roboto',
															    ),
														),

														array(
															'type' => 'radiobutton',
															'name' => 'style',
															'label' => __('Font Style', 'twi_awesome_woo_slider_carousel'),
																		'items' => array(
																			'data' => array(
																				array(
																					'source' => 'binding',
																					'field' => 'font',
																					'value' => 'vp_get_gwf_style',
																				),
																			),
																		),
																		'default' => array(
																			'{{first}}',
																		),
														),

														array(
															'type' => 'radiobutton',
															'name' => 'weight',
															'label' => __('Font Weight', 'twi_awesome_woo_slider_carousel'),
																		'items' => array(
																			'data' => array(
																				array(
																					'source' => 'binding',
																					'field' => 'font',
																					'value' => 'vp_get_gwf_weight',
																				),
																			),
																		),
																		'default' => array(
																			'{{first}}',
																		),
														),

														array(
													        'type' => 'color',
													        'name' => 'cl_bg',
													        'label' => __('Button Background', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#fff',
													    ),

													    array(
													        'type' => 'color',
													        'name' => 'cl_bg_ho',
													        'label' => __('Button Background (Hover)', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#000',
													    ),

														array(
														        'type' => 'slider',
														        'name' => 'cl_bor_wid',
														        'label' => __('Border Width', 'twi_awesome_woo_slider_carousel'),
														        'min' => '0',
														        'max' => '12',
														        'step' => '1',
														        'default' => '2',
														),

														array(
													        'type' => 'color',
													        'name' => 'cl_bor_col',
													        'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#000',
													    ),

													    array(
													        'type' => 'color',
													        'name' => 'cl_bor_col_ho',
													        'label' => __('Border Color (Hover)', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#000',
													    ),

													    array(
														        'type' => 'slider',
														        'name' => 'cl_bor_rad',
														        'label' => __('Border Radius', 'twi_awesome_woo_slider_carousel'),
														        'min' => '0',
														        'max' => '12',
														        'step' => '1',
														        'default' => '0',
														),

														array(
													        'type' => 'color',
													        'name' => 'cl_fo_col',
													        'label' => __('Font Color', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#000',
													    ),

													    array(
													        'type' => 'color',
													        'name' => 'cl_fo_col_ho',
													        'label' => __('Font Color (Hover)', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#fff',
													    ),

													    
									    ),
									),
                                           

							        ),
							    ),

                        
                         	  array(
							    'type' => 'group',
							    'repeating' => false,
							    'length' => 1,
							    'name' => 'twi_carousel_group',
							    'title' => __('Slider/Carousel Settings', 'twi_awesome_woo_slider_carousel'),
							    'dependency' => array(
										'field' => 'twi_woo_g_c_style',
										'function' => 'twi_slider_dep',
								),
							    'fields' => array(
							    	        array(
											        'type' => 'slider',
											        'name' => 'large_desktop',
											        'label' => __('Large Desktops', 'twi_awesome_woo_slider_carousel'),
											        'description' => __('Xlarge (1200px and larger)','twi_awesome_woo_slider_carousel'),
											        'min' => '1',
											        'max' => '12',
											        'step' => '1',
											        'default' => '4',
											),
                                            array(
											        'type' => 'slider',
											        'name' => 'desktop',
											        'label' => __('Desktops & tablets landscape', 'twi_awesome_woo_slider_carousel'),
											        'description' => __('Large (960px to 1199px)','twi_awesome_woo_slider_carousel'),
											        'min' => '1',
											        'max' => '12',
											        'step' => '1',
											        'default' => '4',
											),
                                        
	                                        array(
											        'type' => 'slider',
											        'name' => 'tablet',
											        'label' => __('Tablets portrait', 'twi_awesome_woo_slider_carousel'),
												    'description' => __('Medium (768px to 959px)','twi_awesome_woo_slider_carousel'),
											        'min' => '1',
											        'max' => '12',
											        'step' => '1',
											        'default' => '3',
											),

                                            array(
										        'type' => 'slider',
										        'name' => 'phone_big',
										        'label' => __('Phones landscape', 'twi_awesome_woo_slider_carousel'),
										        'description' => __('Small (480px to 767px)', 'twi_awesome_woo_slider_carousel'),
										        'min' => '1',
										        'max' => '12',
										        'step' => '1',
										        'default' => '2',
										    ),

                                            array(
										        'type' => 'slider',
										        'name' => 'phone',
										        'label' => __('Phones portrait', 'twi_awesome_woo_slider_carousel'),
										        'description' => __('Mini (up to 479px)', 'twi_awesome_woo_slider_carousel'),
										        'min' => '1',
										        'max' => '6',
										        'step' => '1',
										        'default' => '1',
										    ),

										    array(
											'type' => 'radiobutton',
											'name' => 'autoplay',
											'label' => __('Autoplay', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												            'data' => array(
																array(
																	'source' => 'function',
																	'value'  => 'woo_sl_grid_true_false',
																),
															),					
														),
											'default' => array('true'),
										    ),

										    array(
										        'type' => 'slider',
										        'name' => 'autoplaytime',
										        'label' => __('Autoplay Timeout (Sec)', 'twi_awesome_woo_slider_carousel'),
										        'min' => '0.1',
										        'max' => '20',
										        'step' => '0.1',
										        'default' => '5',
										    ),

										    array(
											'type' => 'radiobutton',
											'name' => 'car_hover',
											'label' => __('Autoplay Hover Pause', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												            'data' => array(
																array(
																	'source' => 'function',
																	'value'  => 'woo_sl_grid_true_false',
																),
															),				
														),
											'default' => array('false'),
										    ),

										    array(
											'type' => 'radiobutton',
											'name' => 'car_nav',
											'label' => __('Navigation', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												            'data' => array(
																array(
																	'source' => 'function',
																	'value'  => 'woo_sl_grid_true_false',
																),
															),					
														),
											'default' => array('true'),
										    ),

										 array(
										    'type' => 'group',
										    'repeating' => false,
										    'length' => 1,
										    'name' => 'car_nav_group',
										    'title' => __('Navigation Settings', 'twi_awesome_woo_slider_carousel'),
										    'dependency' => array(
										        'field' => 'car_nav',
												'function' => 'twi_car_nav_set',
											),
										    'fields' => array(
                                            
                                           array(
												'type' => 'html',
												'name' => 'grid_pagi_preview',
												'binding' => array(
													'field' => 'nav_bg,nav_txt,nav_border,nav_bor_wid,nav_bor_rad,nav_bg_h,nav_txt_h,nav_border_h',
													'function' => 'woo_car_nav_fun',
												),
											),
                                            array(
										        'type' => 'color',
										        'name' => 'nav_bg',
										        'label' => __('Background', 'twi_awesome_woo_slider_carousel'),
										        'default' => '#fff',
										    ),
										    array(
										        'type' => 'color',
										        'name' => 'nav_txt',
										        'label' => __('Arrow Color', 'twi_awesome_woo_slider_carousel'),
										        'default' => '#000',
										    ),
										    array(
										        'type' => 'color',
										        'name' => 'nav_border',
										        'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
										        'default' => '#000',
										    ),
										    array(
										        'type' => 'slider',
										        'name' => 'nav_bor_wid',
										        'label' => __('Border Width', 'twi_awesome_woo_slider_carousel'),
										        'min' => '0',
										        'max' => '10',
										        'step' => '1',
										        'default' => '2',
										    ),
										    array(
										        'type' => 'slider',
										        'name' => 'nav_bor_rad',
										        'label' => __('Border Radius(%)', 'twi_awesome_woo_slider_carousel'),
										        'min' => '0',
										        'max' => '50',
										        'step' => '1',
										        'default' => '10',
										    ),



										    array(
										        'type' => 'color',
										        'name' => 'nav_bg_h',
										        'label' => __('Background(Hover)', 'twi_awesome_woo_slider_carousel'),
										        'default' => '#fff',
										    ),
										    array(
										        'type' => 'color',
										        'name' => 'nav_txt_h',
										        'label' => __('Arrow Color(Hover)', 'twi_awesome_woo_slider_carousel'),
										        'default' => '#000',
										    ),
										    array(
										        'type' => 'color',
										        'name' => 'nav_border_h',
										        'label' => __('Border Color(Hover)', 'twi_awesome_woo_slider_carousel'),
										        'default' => '#000',
										    ),

										   array(
											'type' => 'select',
											'name' => 'nav_pos',
											'label' => __('Nav Position', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
															'data' => array(
																array(
																	'source' => 'function',
																	'value'  => 'woo_sl_nav_pos',
																),
															),					
														),
											'default' => array('nav_b_c'),
										    ),

                                        ),
                                    ),
                                          
                                           array(
											'type' => 'radiobutton',
											'name' => 'car_page',
											'label' => __('Pagination', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												            'data' => array(
																array(
																	'source' => 'function',
																	'value'  => 'woo_sl_grid_true_false',
																),
															),				
														),
											'default' => array('false'),
										    ),

                                            array(
											    'type' => 'group',
											    'repeating' => false,
											    'length' => 1,
											    'name' => 'car_page_group',
											    'title' => __('Pagination Settings', 'twi_awesome_woo_slider_carousel'),
											    'dependency' => array(
												    'field' => 'car_page',
													'function' => 'twi_page_show_dep',
												),
											    'fields' => array(
											    	    array(
															'type' => 'html',
															'name' => 'pagination_preview',
															'binding' => array(
																'field' => 'pagi_bg,pagi_border,pagi_bor_wid,pagi_bor_rad,pagi_bg_h,pagi_border_h',
																'function' => 'woo_car_pagi_fun',
															),
														),
			                                            array(
													        'type' => 'color',
													        'name' => 'pagi_bg',
													        'label' => __('Background', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#fff',
													    ),
													    array(
													        'type' => 'color',
													        'name' => 'pagi_border',
													        'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#000',
													    ),
													    array(
													        'type' => 'slider',
													        'name' => 'pagi_bor_wid',
													        'label' => __('Border Width', 'twi_awesome_woo_slider_carousel'),
													        'min' => '0',
													        'max' => '10',
													        'step' => '1',
													        'default' => '2',
													    ),
													    array(
													        'type' => 'slider',
													        'name' => 'pagi_bor_rad',
													        'label' => __('Border Radius(%)', 'twi_awesome_woo_slider_carousel'),
													        'min' => '0',
													        'max' => '50',
													        'step' => '1',
													        'default' => '50',
													    ),

													    array(
													        'type' => 'color',
													        'name' => 'pagi_bg_h',
													        'label' => __('Background(Hover)', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#000000',
													    ),
													    array(
													        'type' => 'color',
													        'name' => 'pagi_border_h',
													        'label' => __('Border Color(Hover)', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#000000',
													    ),
											    ),
											),

							        ),
							    ),

                  
                        // Slide Set

                         array(
							    'type' => 'group',
							    'repeating' => false,
							    'length' => 1,
							    'name' => 'twi_woo_slideset_group',
							    'title' => __('Slide Set Settings', 'twi_awesome_woo_slider_carousel'),
							    'dependency' => array(
										'field' => 'twi_woo_g_c_style',
										'function' => 'twi_woo_st_dep_slideset',
								),
							    'fields' => array(
									  
									        array(
											        'type' => 'slider',
											        'name' => 'large_desktop',
											        'label' => __('Large Desktops', 'twi_awesome_woo_slider_carousel'),
											        'description' => __('Xlarge (1200px and larger)','twi_awesome_woo_slider_carousel'),
											        'min' => '1',
											        'max' => '12',
											        'step' => '1',
											        'default' => '4',
											),
                                            array(
											        'type' => 'slider',
											        'name' => 'desktop',
											        'label' => __('Desktops & tablets landscape', 'twi_awesome_woo_slider_carousel'),
											        'description' => __('Large','twi_awesome_woo_slider_carousel'),
											        'min' => '1',
											        'max' => '12',
											        'step' => '1',
											        'default' => '4',
											),
                                        
	                                        array(
											        'type' => 'slider',
											        'name' => 'tablet',
											        'label' => __('Tablets', 'twi_awesome_woo_slider_carousel'),
												    'description' => __('Medium','twi_awesome_woo_slider_carousel'),
											        'min' => '1',
											        'max' => '12',
											        'step' => '1',
											        'default' => '3',
											),

                                            array(
										        'type' => 'slider',
										        'name' => 'phone_big',
										        'label' => __('Phone', 'twi_awesome_woo_slider_carousel'),
										        'description' => __('Small', 'twi_awesome_woo_slider_carousel'),
										        'min' => '1',
										        'max' => '12',
										        'step' => '1',
										        'default' => '2',
										    ),

										    array(
												'type' => 'radiobutton',
												'name' => 'autoplay',
												'label' => __('Autoplay', 'twi_awesome_woo_slider_carousel'),
												'items' => array(
													            'data' => array(
																	array(
																		'source' => 'function',
																		'value'  => 'woo_sl_grid_true_false',
																	),
																),					
															),
												'default' => array('true'),
										    ),

										    array(
										        'type' => 'slider',
										        'name' => 'autoplaytime',
										        'label' => __('Autoplay Timeout (Sec)', 'twi_awesome_woo_slider_carousel'),
										        'min' => '0.1',
										        'max' => '20',
										        'step' => '0.1',
										        'default' => '5',
										    ),

										    array(
												'type' => 'radiobutton',
												'name' => 'hover_pause',
												'label' => __('Hover Pause', 'twi_awesome_woo_slider_carousel'),
												'items' => array(
													            'data' => array(
																	array(
																		'source' => 'function',
																		'value'  => 'woo_sl_grid_true_false',
																	),
																),					
															),
												'default' => array('false'),
										    ),

										    array(
												'type' => 'select',
												'name' => 'animation',
												'label' => __('Animation', 'twi_awesome_woo_slider_carousel'),
												'items' => array(
													            'data' => array(
																	array(
																		'source' => 'function',
																		'value'  => 'woo_slideset_ani',
																	),
																),					
															),
												'default' => array('fade'),
										    ),

										    array(
												'type' => 'radiobutton',
												'name' => 'nav',
												'label' => __('Navigation', 'twi_awesome_woo_slider_carousel'),
												'items' => array(
													            'data' => array(
																	array(
																		'source' => 'function',
																		'value'  => 'woo_sl_grid_true_false',
																	),
																),					
															),
												'default' => array('true'),
										    ),

										    array(
												'type' => 'radiobutton',
												'name' => 'page',
												'label' => __('Pagination', 'twi_awesome_woo_slider_carousel'),
												'items' => array(
													            'data' => array(
																	array(
																		'source' => 'function',
																		'value'  => 'woo_sl_grid_true_false',
																	),
																),					
															),
												'default' => array('true'),
										    ),

										    array(
												'type' => 'radiobutton',
												'name' => 'forced_cen',
												'label' => __('Forced Center (Items)', 'twi_awesome_woo_slider_carousel'),
												'items' => array(
													            'data' => array(
																	array(
																		'source' => 'function',
																		'value'  => 'woo_sl_grid_true_false',
																	),
																),					
															),
												'default' => array('true'),
										    ),

							    ),
						),
                       
                        array(
							'type' => 'slider',
							'dependency' => array(
								'field' => 'twi_woo_g_c_style',
								'function' => 'twi_woo_justified_mar',
							),
							'name' => 'just_mar',
							'label' => __('Justified Grid Margin', 'twi_awesome_woo_slider_carousel'),
							'min' => '0',
							'max' => '10',
							'step' => '1',
							'default' => '1',
						),                       

 	      			   array(
							'type' => 'radiobutton',
							'name' => 'twi_pro_orderby',
							'label' => __('Product Orderby', 'twi_awesome_woo_slider_carousel'),
							'items' => array(
								            'data' => array(
												array(
													'source' => 'function',
													'value'  => 'woo_sl_order_by',
												),
											),			
										),
							'default' => array('title'),
						),

 	      			   array(
							'type' => 'radiobutton',
							'name' => 'twi_pro_order',
							'label' => __('Product Order', 'twi_awesome_woo_slider_carousel'),
							'items' => array(
								            'data' => array(
												array(
													'source' => 'function',
													'value'  => 'woo_sl_pro_order',
												),
											),						
										),
							'default' => array('desc'),
						),

 	      			   array(
									'type' => 'radiobutton',
									'name' => 'title',
									'label' => __('Title Display for products/category', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
										            'data' => array(
														array(
															'source' => 'function',
															'value'  => 'woo_sl_grid_yes_no',
														),
													),						
												),
									'default' => array('yes'),
								),

 	      			   array(
									'type' => 'radiobutton',
									'name' => 'des',
									'label' => __('Short Description Display for products/category', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
										            'data' => array(
														array(
															'source' => 'function',
															'value'  => 'woo_sl_grid_yes_no',
														),
													),						
												),
									'default' => array('no'),
								),

 	      			   array(
									'type' => 'radiobutton',
									'name' => 'price_h_s',
									'label' => __('Price/Category item count Display', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
										            'data' => array(
														array(
															'source' => 'function',
															'value'  => 'woo_sl_grid_yes_no',
														),
													),						
												),
									'default' => array('yes'),
								),

 	      			   array(
									'type' => 'radiobutton',
									'name' => 'cart',
									'label' => __('Cart Show', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
										            'data' => array(
														array(
															'source' => 'function',
															'value'  => 'woo_sl_grid_yes_no',
														),
													),						
												),
									'default' => array('yes'),
								),

 	      			   array(
									'type' => 'radiobutton',
									'name' => 'rating',
									'label' => __('Rating Show', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
										            'data' => array(
														array(
															'source' => 'function',
															'value'  => 'woo_sl_grid_yes_no',
														),
													),					
												),
									'default' => array('no'),
								),

 	      			   array(
									'type' => 'radiobutton',
									'name' => 'forced_full_screen',
									'label' => __('Forced Full Screen', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
										            'data' => array(
														array(
															'source' => 'function',
															'value'  => 'woo_sl_grid_yes_no',
														),
													),					
												),
									'default' => array('no'),
					  ),

 	      			  array(
									'type' => 'radiobutton',
									'name' => 'preloader',
									'label' => __('Preloader', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
										            'data' => array(
														array(
															'source' => 'function',
															'value'  => 'woo_sl_grid_yes_no',
														),
													),					
												),
									'default' => array('yes'),
					  ),

 	      			   array(
							    'type' => 'group',
							    'repeating' => false,
							    'length' => 1,
							    'name' => 'twi_woo_rib_main',
							    'title' => __('Ribbon/Label Settings', 'twi_awesome_woo_slider_carousel'),
							    'fields' => array(
							    	array(
										'type' => 'radiobutton',
										'name' => 'twi_rib_dis',
										'label' => __('Ribbon/Label Display', 'twi_awesome_woo_slider_carousel'),
										'items' => array(
											            'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_grid_yes_no',
															),
														),					
													),
										     'default' => array('yes'),
					                     ),
					    
					                array(
										'type' => 'radiobutton',
										'name' => 'twi_fe_lab_pos',
										'label' => __('Featured Label Position', 'twi_awesome_woo_slider_carousel'),
										'items' => array(
											            'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_styles',
															),
														),				
													),
										'default' => array('right'),
					                ),
					                
							    ),
							),

                               array(
									'type' => 'radiobutton',
									'name' => 'twi_temp_style',
									'label' => __('Template Styles With Live Preview', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
												   'data' => array(
														array(
															'source' => 'function',
															'value'  => 'woo_sl_temp_style',
														),
													),												
										),
								    'default' => array('normal'),
								),


								array(
								    'type'      => 'group',
								    'repeating' => false,
								    'length'    => 1,
								    'name'      => 'nor_preview_group',
								    'title'     => __('Normal Style Preview', 'twi_awesome_woo_slider_carousel'),
								    'dependency' => array(
										'field' => 'twi_temp_style',
										'function' => 'woo_no_pre_fun',
									),
								    'fields'    => array(
								    	array(
											'type' => 'html',
											'name' => 'normal_live_preview',
											'binding' => array(
												'field' => 'font,style,weight,nor_bg,nor_border,nor_bor_col,nor_border_width,nor_con_pos,h3_col,h3_col_hover,h3_font_size,h3_txt_trans,fo_color,fo_size,star_color,cart_col,cart_col_hover,cart_bg,cart_bg_hover,cart_bor,cart_bor_hover,cart_bor_wid,cart_txt_trans,cart_bor_rad,cart_fo_size,sale_bg,sale_txt,out_bg,out_txt,fe_bg,fe_txt,st_si,des_col,des_font_size,des_line_height',
												'function' => 'woo_nor_live_preview',
										     ),
										),
										array(
										'type' => 'select',
										'name' => 'font',
										'label' => __('Font Face', 'twi_awesome_woo_slider_carousel'),
										'description' => __('<b>Default:</b> Roboto', 'twi_awesome_woo_slider_carousel'),
										'items' => array(
													'data' => array(
														array(
															'source' => 'function',
															'value' => 'vp_get_gwf_family',
														),
													),
												),
												'default' => array(
													'Roboto',
										    ),
										),

										array(
										'type' => 'radiobutton',
										'name' => 'style',
										'label' => __('Font Style', 'twi_awesome_woo_slider_carousel'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_style',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),
									array(
										'type' => 'radiobutton',
										'name' => 'weight',
										'label' => __('Font Weight', 'twi_awesome_woo_slider_carousel'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_weight',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),
									array(
											'type' => 'color',
											'name' => 'nor_bg',
											'label' => __('Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#eee',
									),
									array(
											'type' => 'radiobutton',
											'name' => 'nor_con_pos',
											'label' => __('Content Position', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_pagi_pos',
															),
														),										
													),
										    'default' => array('left'),
									),
									array(
										    'type' => 'slider',
										    'name' => 'nor_border',
										    'label' => __('Border Radius', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),
									array(
											'type' => 'color',
											'name' => 'nor_bor_col',
											'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#eee',
									),
									array(
										    'type' => 'slider',
										    'name' => 'nor_border_width',
										    'label' => __('Border Thickness', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

										array(
									        'type' => 'notebox',
									        'name' => 'nb_1',
									        'description' => __('<h3>Product/Category Title Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),

										array(
											'type' => 'color',
											'name' => 'h3_col',
											'label' => __('Title Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
										),
										array(
											'type' => 'color',
											'name' => 'h3_col_hover',
											'label' => __('Title Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
										),
										array(
										    'type' => 'slider',
										    'name' => 'h3_font_size',
										    'label' => __('Title Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '16',
										),
										array(
											'type' => 'radiobutton',
											'name' => 'h3_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_txt_trans',
															),
														),								
													),
										    'default' => array('inherit'),
										),


										array(
									        'type' => 'notebox',
									        'name' => 'nb_des',
									        'description' => __('<h3>Product/Category Description Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),

										array(
											'type' => 'color',
											'name' => 'des_col',
											'label' => __('Description Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
										),
										
										array(
										    'type' => 'slider',
										    'name' => 'des_font_size',
										    'label' => __('Description Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '10',
										    'max' => '75',
										    'step' => '1',
										    'default' => '12',
										),

										array(
										    'type' => 'slider',
										    'name' => 'des_line_height',
										    'label' => __('Description Line Height', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '17',
										),


										array(
									        'type' => 'notebox',
									        'name' => 'nb_2',
									        'description' => __('<h3>Product Price Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),

									array(
											'type' => 'color',
											'name' => 'fo_color',
											'label' => __('Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
										    'type' => 'slider',
										    'name' => 'fo_size',
										    'label' => __('Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '12',
										),
									array(
									        'type' => 'notebox',
									        'name' => 'nb_3',
									        'description' => __('<h3>Product Star Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),
									array(
										'type' => 'color',
										'name' => 'star_color',
										'label' => __('Star Color', 'twi_awesome_woo_slider_carousel'),
										'default' => '#000',
									),
									array(
										    'type' => 'slider',
										    'name' => 'st_si',
										    'label' => __('Star Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '25',
										    'step' => '1',
										    'default' => '12',
										),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_4',
									        'description' => __('<h3>Cart Settings</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col',
											'label' => __('Cart Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
											'type' => 'radiobutton',
											'name' => 'cart_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														  'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_txt_trans',
															),
														),									
													),
										    'default' => array('inherit'),
										),

									array(
											'type' => 'color',
											'name' => 'cart_bg',
											'label' => __('Cart Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_fo_size',
										    'label' => __('Cart Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '50',
										    'step' => '1',
										    'default' => '14',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_wid',
										    'label' => __('Cart Border Width', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '2',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor',
											'label' => __('Cart Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col_hover',
											'label' => __('Cart Text Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bg_hover',
											'label' => __('Cart Background (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor_hover',
											'label' => __('Cart Border Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_rad',
										    'label' => __('Cart Border Radius', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_5',
									        'description' => __('<h3>Label/Ribbon Settings</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'sale_bg',
											'label' => __('Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'sale_txt',
											'label' => __('Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'out_bg',
											'label' => __('Out of Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#DC6868',
									),
									array(
											'type' => 'color',
											'name' => 'out_txt',
											'label' => __('Out of Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'fe_bg',
											'label' => __('Featured Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'fe_txt',
											'label' => __('Featured Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									


								    ),
								 ),



								array(
								    'type'      => 'group',
								    'repeating' => false,
								    'length'    => 1,
								    'name'      => 'img_preview_group',
								    'title'     => __('Image Only Preview', 'twi_awesome_woo_slider_carousel'),
								    'dependency' => array(
										'field' => 'twi_temp_style',
										'function' => 'woo_img_pre_fun',
									),
								    'fields'    => array(
								    	array(
											'type' => 'html',
											'name' => 'img_live_preview',
											'binding' => array(
												'field' => 'font,style,weight,nor_border,nor_bor_col,nor_border_width,sale_bg,sale_txt,out_bg,out_txt,fe_bg,fe_txt',
												'function' => 'woo_img_live_preview',
										     ),
										),
										array(
										'type' => 'select',
										'name' => 'font',
										'label' => __('Font Face', 'twi_awesome_woo_slider_carousel'),
										'description' => __('<b>Default:</b> Roboto', 'twi_awesome_woo_slider_carousel'),
										'items' => array(
													'data' => array(
														array(
															'source' => 'function',
															'value' => 'vp_get_gwf_family',
														),
													),
												),
												'default' => array(
													'Roboto',
										    ),
										),

										array(
										'type' => 'radiobutton',
										'name' => 'style',
										'label' => __('Font Style', 'twi_awesome_woo_slider_carousel'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_style',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),
									array(
										'type' => 'radiobutton',
										'name' => 'weight',
										'label' => __('Font Weight', 'twi_awesome_woo_slider_carousel'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_weight',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),
									array(
										    'type' => 'slider',
										    'name' => 'nor_border',
										    'label' => __('Border Radius', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),
									array(
											'type' => 'color',
											'name' => 'nor_bor_col',
											'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#eee',
									),
									array(
										    'type' => 'slider',
										    'name' => 'nor_border_width',
										    'label' => __('Border Thickness', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_5',
									        'description' => __('<h3>Label/Ribbon Settings</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'sale_bg',
											'label' => __('Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'sale_txt',
											'label' => __('Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'out_bg',
											'label' => __('Out of Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#DC6868',
									),
									array(
											'type' => 'color',
											'name' => 'out_txt',
											'label' => __('Out of Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'fe_bg',
											'label' => __('Featured Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'fe_txt',
											'label' => __('Featured Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									


								    ),
								 ),

								array(
								    'type'      => 'group',
								    'repeating' => false,
								    'length'    => 1,
								    'name'      => 'hover_preview_group',
								    'title'     => __('Hover Style Preview', 'twi_awesome_woo_slider_carousel'),
								    'dependency' => array(
										'field' => 'twi_temp_style',
										'function' => 'woo_hover_pre_fun',
									),
								    'fields'    => array(
								    	array(
											'type' => 'html',
											'name' => 'hover_live_preview',
											'binding' => array(
												'field' => 'font,style,weight,nor_bg,nor_border,nor_bor_col,nor_border_width,h3_col,h3_col_hover,h3_font_size,h3_txt_trans,fo_color,fo_size,star_color,cart_col,cart_col_hover,cart_bg,cart_bg_hover,cart_bor,cart_bor_hover,cart_bor_wid,cart_txt_trans,cart_bor_rad,cart_fo_size,sale_bg,sale_txt,out_bg,out_txt,fe_bg,fe_txt,st_si,over_eff,img_eff,title_an,price_an,rating_an,cart_an,des_col,des_font_size,des_line_height,des_an',
												'function' => 'woo_hover_live_preview',
										     ),
										),
										array(
										'type' => 'select',
										'name' => 'font',
										'label' => __('Font Face', 'twi_awesome_woo_slider_carousel'),
										'description' => __('<b>Default:</b> Roboto', 'twi_awesome_woo_slider_carousel'),
										'items' => array(
													'data' => array(
														array(
															'source' => 'function',
															'value' => 'vp_get_gwf_family',
														),
													),
												),
												'default' => array(
													'Roboto',
										    ),
										),

										array(
										'type' => 'radiobutton',
										'name' => 'style',
										'label' => __('Font Style', 'twi_awesome_woo_slider_carousel'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_style',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),
									array(
										'type' => 'radiobutton',
										'name' => 'weight',
										'label' => __('Font Weight', 'twi_awesome_woo_slider_carousel'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_weight',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),

                                    array(
								        'type' => 'select',
								        'name' => 'over_eff',
								        'label' => __('Overlay Effects', 'twi_awesome_woo_slider_carousel'),
								        'items' => array(
								        	'data' => array(
												array(
													'source' => 'function',
													'value' => 'woo_sl_over_eff',
												),
											),
								        ),
								        'default' => array(
								            'fade',
								        ),
								    ),



                                    
                                    array(
								        'type' => 'radiobutton',
								        'name' => 'img_eff',
								        'label' => __('Overlay Effects', 'twi_awesome_woo_slider_carousel'),
								        'items' => array(
								        	'data' => array(
												array(
													'source' => 'function',
													'value' => 'woo_sl_img_eff',
												),
											),
								        ),
								        'default' => array(
								            'twi-img-normal',
								        ),
								    ),

									array(
											'type' => 'color',
											'name' => 'nor_bg',
											'label' => __('Background', 'twi_awesome_woo_slider_carousel'),
											'default' => 'rgba(44, 62, 80, 0.5)',
											'format' => 'rgba',
									),
									
									array(
										    'type' => 'slider',
										    'name' => 'nor_border',
										    'label' => __('Border Radius(%)', 'twi_awesome_woo_slider_carousel'),
										    'description' => __('50% --> Circle', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '50',
										    'step' => '1',
										    'default' => '0',
									),
									array(
											'type' => 'color',
											'name' => 'nor_bor_col',
											'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#eee',
									),
									array(
										    'type' => 'slider',
										    'name' => 'nor_border_width',
										    'label' => __('Border Thickness', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

										array(
									        'type' => 'notebox',
									        'name' => 'nb_1',
									        'description' => __('<h3>Product/Category Title Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),

										array(
											'type' => 'color',
											'name' => 'h3_col',
											'label' => __('Title Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
										),
										array(
											'type' => 'color',
											'name' => 'h3_col_hover',
											'label' => __('Title Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
										),
										array(
										    'type' => 'slider',
										    'name' => 'h3_font_size',
										    'label' => __('Title Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '16',
										),
										array(
											'type' => 'radiobutton',
											'name' => 'h3_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_txt_trans',
															),
														),									
													),
										    'default' => array('inherit'),
										),

										array(
										 'name'  => 'title_an',
										 'type'  => 'select',
										 'label' => __('Title animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										                'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_animations_sets',
															),
														),										      
											   ),
											    'default' => 'no-animtion',
										    ),


										array(
									        'type' => 'notebox',
									        'name' => 'nb_des',
									        'description' => __('<h3>Product/Category Description Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),

										array(
											'type' => 'color',
											'name' => 'des_col',
											'label' => __('Description Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
										),
										array(
										    'type' => 'slider',
										    'name' => 'des_font_size',
										    'label' => __('Description Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '10',
										    'max' => '75',
										    'step' => '1',
										    'default' => '12',
										),

										array(
										    'type' => 'slider',
										    'name' => 'des_line_height',
										    'label' => __('Description Line Height', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '16',
										),

										array(
										 'name'  => 'des_an',
										 'type'  => 'select',
										 'label' => __('Description animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										                'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_animations_sets',
															),
														),										      
											   ),
											    'default' => 'no-animtion',
										),
										    

										array(
									        'type' => 'notebox',
									        'name' => 'nb_2',
									        'description' => __('<h3>Product Price Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),

									array(
											'type' => 'color',
											'name' => 'fo_color',
											'label' => __('Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
										    'type' => 'slider',
										    'name' => 'fo_size',
										    'label' => __('Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '12',
										),

									array(
										 'name'  => 'price_an',
										 'type'  => 'select',
										 'label' => __('Price animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										            'data' => array(
														array(
															'source' => 'function',
															'value'  => 'woo_sl_animations_sets',
														),
													),
											  											      
											   ),
											    'default' => 'no-animtion',
										    ),
									array(
									        'type' => 'notebox',
									        'name' => 'nb_3',
									        'description' => __('<h3>Product Star Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),
									array(
										'type' => 'color',
										'name' => 'star_color',
										'label' => __('Star Color', 'twi_awesome_woo_slider_carousel'),
										'default' => '#fff',
									),
									array(
										    'type' => 'slider',
										    'name' => 'st_si',
										    'label' => __('Star Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '25',
										    'step' => '1',
										    'default' => '12',
										),

									array(
										 'name'  => 'rating_an',
										 'type'  => 'select',
										 'label' => __('Rating animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										          'data' => array(
														array(
															'source' => 'function',
															'value'  => 'woo_sl_animations_sets',
													    ),
													),										      
											   ),
											    'default' => 'no-animtion',
										    ),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_4',
									        'description' => __('<h3>Cart Settings</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col',
											'label' => __('Cart Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
											'type' => 'radiobutton',
											'name' => 'cart_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_txt_trans',
															),
														),								
													),
										    'default' => array('inherit'),
										),

									array(
											'type' => 'color',
											'name' => 'cart_bg',
											'label' => __('Cart Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
											'format' => 'rgba',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_fo_size',
										    'label' => __('Cart Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '50',
										    'step' => '1',
										    'default' => '12',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_wid',
										    'label' => __('Cart Border Width', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '2',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor',
											'label' => __('Cart Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col_hover',
											'label' => __('Cart Text Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bg_hover',
											'label' => __('Cart Background (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
											'format' => 'rgba',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor_hover',
											'label' => __('Cart Border Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_rad',
										    'label' => __('Cart Border Radius', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

									array(
										 'name'  => 'cart_an',
										 'type'  => 'select',
										 'label' => __('Cart button animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										                'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_animations_sets',
															),
														),
											  											      
										),
									    'default' => 'no-animtion',
									),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_5',
									        'description' => __('<h3>Label/Ribbon Settings</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'sale_bg',
											'label' => __('Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'sale_txt',
											'label' => __('Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'out_bg',
											'label' => __('Out of Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#DC6868',
									),
									array(
											'type' => 'color',
											'name' => 'out_txt',
											'label' => __('Out of Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'fe_bg',
											'label' => __('Featured Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'fe_txt',
											'label' => __('Featured Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									


								    ),
								 ),

/* Hover Set 2*/
								array(
								    'type'      => 'group',
								    'repeating' => false,
								    'length'    => 1,
								    'name'      => 'hover2_preview_group',
								    'title'     => __('Hover Style Preview', 'twi_awesome_woo_slider_carousel'),
								    'dependency' => array(
										'field' => 'twi_temp_style',
										'function' => 'woo_hover2_pre_fun',
									),
								    'fields'    => array(
								    	array(
											'type' => 'html',
											'name' => 'hover2_live_preview',
											'binding' => array(
												'field' => 'font,style,weight,nor_bg,nor_border,nor_bor_col,nor_border_width,h3_col,h3_col_hover,h3_font_size,h3_txt_trans,fo_color,fo_size,star_color,cart_col,cart_col_hover,cart_bg,cart_bg_hover,cart_bor,cart_bor_hover,cart_bor_wid,cart_txt_trans,cart_bor_rad,cart_fo_size,sale_bg,sale_txt,out_bg,out_txt,fe_bg,fe_txt,st_si,overlay_eff,img_eff,title_an,price_an,rating_an,cart_an,des_col,des_font_size,des_line_height,des_an',
												'function' => 'twi_woo_hover_set2',
										     ),
										),

										array(
										'type' => 'select',
										'name' => 'font',
										'label' => __('Font Face', 'twi_awesome_woo_slider_carousel'),
										'description' => __('<b>Default:</b> Roboto', 'twi_awesome_woo_slider_carousel'),
										'items' => array(
													'data' => array(
														array(
															'source' => 'function',
															'value' => 'vp_get_gwf_family',
														),
													),
												),
												'default' => array(
													'Roboto',
										    ),
										),

										array(
										'type' => 'radiobutton',
										'name' => 'style',
										'label' => __('Font Style', 'twi_awesome_woo_slider_carousel'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_style',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),
									array(
										'type' => 'radiobutton',
										'name' => 'weight',
										'label' => __('Font Weight', 'twi_awesome_woo_slider_carousel'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_weight',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),

                                   
										array(
									        'type' => 'select',
									        'name' => 'overlay_eff',
									        'label' => __('Overlay Effect', 'twi_awesome_woo_slider_carousel'),
									        'items' => array(
									            'data' => array(
									                array(
									                    'source' => 'function',
									                    'value' => 'twi_woo_ho2_eff',
									                ),
									            ),
									        ),
									        'default' => '1',
									    ),

										array(
									        'type' => 'select',
									        'name' => 'img_eff',
									        'label' => __('Image Effect', 'twi_awesome_woo_slider_carousel'),
									        'items' => array(
									            'data' => array(
									                array(
									                    'source' => 'function',
									                    'value' => 'twi_woo_ho2_img',
									                ),
									            ),
									        ),
									        'default' => '1',
									    ),

									array(
											'type' => 'color',
											'name' => 'nor_bg',
											'label' => __('Background', 'twi_awesome_woo_slider_carousel'),
											'default' => 'rgba(44, 62, 80, 0.5)',
											'format' => 'rgba',
									),
									
									array(
										    'type' => 'slider',
										    'name' => 'nor_border',
										    'label' => __('Border Radius(%)', 'twi_awesome_woo_slider_carousel'),
										    'description' => __('50% --> Circle', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '50',
										    'step' => '1',
										    'default' => '0',
									),
									array(
											'type' => 'color',
											'name' => 'nor_bor_col',
											'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#eee',
									),
									array(
										    'type' => 'slider',
										    'name' => 'nor_border_width',
										    'label' => __('Border Thickness', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

										array(
									        'type' => 'notebox',
									        'name' => 'nb_1',
									        'description' => __('<h3>Product/Category Title Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),

										array(
											'type' => 'color',
											'name' => 'h3_col',
											'label' => __('Title Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
										),
										array(
											'type' => 'color',
											'name' => 'h3_col_hover',
											'label' => __('Title Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
										),
										array(
										    'type' => 'slider',
										    'name' => 'h3_font_size',
										    'label' => __('Title Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '16',
										),
										array(
											'type' => 'radiobutton',
											'name' => 'h3_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_txt_trans',
															),
														),									
													),
										    'default' => array('inherit'),
										),

										array(
										 'name'  => 'title_an',
										 'type'  => 'select',
										 'label' => __('Title animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										                'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_animations_sets',
															),
														),										      
											   ),
											    'default' => 'no-animtion',
										    ),


										array(
									        'type' => 'notebox',
									        'name' => 'nb_des',
									        'description' => __('<h3>Product/Category Description Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),

										array(
											'type' => 'color',
											'name' => 'des_col',
											'label' => __('Description Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
										),
										array(
										    'type' => 'slider',
										    'name' => 'des_font_size',
										    'label' => __('Description Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '10',
										    'max' => '75',
										    'step' => '1',
										    'default' => '12',
										),

										array(
										    'type' => 'slider',
										    'name' => 'des_line_height',
										    'label' => __('Description Line Height', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '16',
										),

										array(
										 'name'  => 'des_an',
										 'type'  => 'select',
										 'label' => __('Description animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										                'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_animations_sets',
															),
														),										      
											   ),
											    'default' => 'no-animtion',
										),
										    

										array(
									        'type' => 'notebox',
									        'name' => 'nb_2',
									        'description' => __('<h3>Product Price Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),

									array(
											'type' => 'color',
											'name' => 'fo_color',
											'label' => __('Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
										    'type' => 'slider',
										    'name' => 'fo_size',
										    'label' => __('Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '12',
										),

									array(
										 'name'  => 'price_an',
										 'type'  => 'select',
										 'label' => __('Price animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										            'data' => array(
														array(
															'source' => 'function',
															'value'  => 'woo_sl_animations_sets',
														),
													),
											  											      
											   ),
											    'default' => 'no-animtion',
										    ),
									array(
									        'type' => 'notebox',
									        'name' => 'nb_3',
									        'description' => __('<h3>Product Star Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),
									array(
										'type' => 'color',
										'name' => 'star_color',
										'label' => __('Star Color', 'twi_awesome_woo_slider_carousel'),
										'default' => '#fff',
									),
									array(
										    'type' => 'slider',
										    'name' => 'st_si',
										    'label' => __('Star Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '25',
										    'step' => '1',
										    'default' => '12',
										),

									array(
										 'name'  => 'rating_an',
										 'type'  => 'select',
										 'label' => __('Rating animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										          'data' => array(
														array(
															'source' => 'function',
															'value'  => 'woo_sl_animations_sets',
													    ),
													),										      
											   ),
											    'default' => 'no-animtion',
										    ),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_4',
									        'description' => __('<h3>Cart Settings</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col',
											'label' => __('Cart Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
											'type' => 'radiobutton',
											'name' => 'cart_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_txt_trans',
															),
														),								
													),
										    'default' => array('inherit'),
										),

									array(
											'type' => 'color',
											'name' => 'cart_bg',
											'label' => __('Cart Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
											'format' => 'rgba',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_fo_size',
										    'label' => __('Cart Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '50',
										    'step' => '1',
										    'default' => '12',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_wid',
										    'label' => __('Cart Border Width', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '2',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor',
											'label' => __('Cart Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col_hover',
											'label' => __('Cart Text Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bg_hover',
											'label' => __('Cart Background (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
											'format' => 'rgba',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor_hover',
											'label' => __('Cart Border Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_rad',
										    'label' => __('Cart Border Radius', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

									array(
										 'name'  => 'cart_an',
										 'type'  => 'select',
										 'label' => __('Cart button animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										                'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_animations_sets',
															),
														),
											  											      
										),
									    'default' => 'no-animtion',
									),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_5',
									        'description' => __('<h3>Label/Ribbon Settings</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'sale_bg',
											'label' => __('Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'sale_txt',
											'label' => __('Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'out_bg',
											'label' => __('Out of Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#DC6868',
									),
									array(
											'type' => 'color',
											'name' => 'out_txt',
											'label' => __('Out of Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'fe_bg',
											'label' => __('Featured Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'fe_txt',
											'label' => __('Featured Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									


								    ),
								 ),
/*Hover set 2*/



								array(
								    'type'      => 'group',
								    'repeating' => false,
								    'length'    => 1,
								    'name'      => 'over_preview_group',
								    'title'     => __('Overlay Style Preview', 'twi_awesome_woo_slider_carousel'),
								    'dependency' => array(
										'field' => 'twi_temp_style',
										'function' => 'woo_over_pre_fun',
									),
								    'fields'    => array(
								    	array(
											'type' => 'html',
											'name' => 'over_live_preview',
											'binding' => array(
												'field' => 'font,style,weight,nor_bg,nor_border,nor_bor_col,nor_border_width,h3_col,h3_col_hover,h3_font_size,h3_txt_trans,fo_color,fo_size,star_color,cart_col,cart_col_hover,cart_bg,cart_bg_hover,cart_bor,cart_bor_hover,cart_bor_wid,cart_txt_trans,cart_bor_rad,cart_fo_size,sale_bg,sale_txt,out_bg,out_txt,fe_bg,fe_txt,st_si,des_col,des_font_size,des_line_height',
												'function' => 'woo_over_live_preview',
										     ),
										),
										array(
										'type' => 'select',
										'name' => 'font',
										'label' => __('Font Face', 'twi_awesome_woo_slider_carousel'),
										'description' => __('<b>Default:</b> Roboto', 'twi_awesome_woo_slider_carousel'),
										'items' => array(
													'data' => array(
														array(
															'source' => 'function',
															'value' => 'vp_get_gwf_family',
														),
													),
												),
												'default' => array(
													'Roboto',
										    ),
										),

										array(
										'type' => 'radiobutton',
										'name' => 'style',
										'label' => __('Font Style', 'twi_awesome_woo_slider_carousel'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_style',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),
									array(
										'type' => 'radiobutton',
										'name' => 'weight',
										'label' => __('Font Weight', 'twi_awesome_woo_slider_carousel'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_weight',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),


									array(
											'type' => 'color',
											'name' => 'nor_bg',
											'label' => __('Background', 'twi_awesome_woo_slider_carousel'),
											'default' => 'rgba(44, 62, 80, 0.5)',
											'format' => 'rgba',
									),
									
									array(
										    'type' => 'slider',
										    'name' => 'nor_border',
										    'label' => __('Border Radius(%)', 'twi_awesome_woo_slider_carousel'),
										    'description' => __('50% --> Circle', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '50',
										    'step' => '1',
										    'default' => '0',
									),
									array(
											'type' => 'color',
											'name' => 'nor_bor_col',
											'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#eee',
									),
									array(
										    'type' => 'slider',
										    'name' => 'nor_border_width',
										    'label' => __('Border Thickness', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

										array(
									        'type' => 'notebox',
									        'name' => 'nb_1',
									        'description' => __('<h3>Product/Category Title Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),

										array(
											'type' => 'color',
											'name' => 'h3_col',
											'label' => __('Title Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
										),
										array(
											'type' => 'color',
											'name' => 'h3_col_hover',
											'label' => __('Title Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
										),
										array(
										    'type' => 'slider',
										    'name' => 'h3_font_size',
										    'label' => __('Title Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '16',
										),
										array(
											'type' => 'radiobutton',
											'name' => 'h3_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_txt_trans',
															),
														),									
													),
										    'default' => array('inherit'),
										),


										array(
									        'type' => 'notebox',
									        'name' => 'nb_des',
									        'description' => __('<h3>Product/Category Description Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),

										array(
											'type' => 'color',
											'name' => 'des_col',
											'label' => __('Description Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
										),
										array(
										    'type' => 'slider',
										    'name' => 'des_font_size',
										    'label' => __('Description Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '10',
										    'max' => '75',
										    'step' => '1',
										    'default' => '12',
										),

										array(
										    'type' => 'slider',
										    'name' => 'des_line_height',
										    'label' => __('Description Line Height', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '16',
										),
										    

										array(
									        'type' => 'notebox',
									        'name' => 'nb_2',
									        'description' => __('<h3>Product Price Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),

									array(
											'type' => 'color',
											'name' => 'fo_color',
											'label' => __('Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
										    'type' => 'slider',
										    'name' => 'fo_size',
										    'label' => __('Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '10',
										    'max' => '75',
										    'step' => '1',
										    'default' => '12',
										),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_3',
									        'description' => __('<h3>Product Star Setting</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									    ),
									array(
										'type' => 'color',
										'name' => 'star_color',
										'label' => __('Star Color', 'twi_awesome_woo_slider_carousel'),
										'default' => '#fff',
									),
									array(
										    'type' => 'slider',
										    'name' => 'st_si',
										    'label' => __('Star Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '25',
										    'step' => '1',
										    'default' => '13',
										),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_4',
									        'description' => __('<h3>Cart Settings</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col',
											'label' => __('Cart Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
											'type' => 'radiobutton',
											'name' => 'cart_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														'data' => array(
															array(
																'source' => 'function',
																'value'  => 'woo_sl_txt_trans',
															),
														),									
													),
										    'default' => array('inherit'),
										),

									array(
											'type' => 'color',
											'name' => 'cart_bg',
											'label' => __('Cart Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
											'format' => 'rgba',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_fo_size',
										    'label' => __('Cart Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '10',
										    'max' => '50',
										    'step' => '1',
										    'default' => '12',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_wid',
										    'label' => __('Cart Border Width', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '2',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor',
											'label' => __('Cart Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col_hover',
											'label' => __('Cart Text Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bg_hover',
											'label' => __('Cart Background (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
											'format' => 'rgba',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor_hover',
											'label' => __('Cart Border Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_rad',
										    'label' => __('Cart Border Radius', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_5',
									        'description' => __('<h3>Label/Ribbon Settings</h3>', 'twi_awesome_woo_slider_carousel'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'sale_bg',
											'label' => __('Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'sale_txt',
											'label' => __('Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'out_bg',
											'label' => __('Out of Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#DC6868',
									),
									array(
											'type' => 'color',
											'name' => 'out_txt',
											'label' => __('Out of Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'fe_bg',
											'label' => __('Featured Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'fe_txt',
											'label' => __('Featured Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									


								    ),
								 ),

             
 	),
 );
?>