<?php

namespace Drupal\geo_ip_block\Plugin\Block;

use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Block\BlockBase;

use GeoIp2\WebService\Client;

/**
 * Provides a 'phone number' Block.
 *
 * @Block(
 *   id = "cus_phone_block",
 *   admin_label = @Translation("Custom phone number"),
 * )
 */
class GeoIpBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
 /* public function build() {
    return array(
      '#type' => 'markup',
      '#markup' => 'This block list the article.',
    );
  }*/

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['cus_phone_block_ph_no_eng'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Telephone no for England'),
      '#description' => $this->t('Give me your ph number?'),
      '#default_value' => isset($config['ph_no_eng']) ? $config['ph_no_eng'] : '',
    );
    $form['cus_phone_block_ph_no_sot'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Telephone no for Scotland'),
      '#default_value' => isset($config['ph_no_sot']) ? $config['ph_no_sot'] : '',
    );
	   $form['cus_phone_block_ph_no_ire'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Telephone no for Ireland'),
      '#default_value' => isset($config['ph_no_ire']) ? $config['ph_no_ire'] : '',
    );

    return $form;
  }

   /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['ph_no_eng'] = $form_state->getValue('cus_phone_block_ph_no_eng');
    $this->configuration['ph_no_sot'] = $form_state->getValue('cus_phone_block_ph_no_sot');
    $this->configuration['ph_no_ire'] = $form_state->getValue('cus_phone_block_ph_no_ire');
  }

  public function build() {
    $config = $this->getConfiguration();

    $client = new Client(******, '********');
	  $record = $client->city('213.120.117.247'); // e.g. 84.92.85.168 194.159.178.180  209.170.124.203 I
	  //print_r($record);

	  $subdivision = $record->subdivisions[0]->names['en'];

	
    if (!empty($config['ph_no_eng']))
    	{
      	$ph_no = $config['ph_no_eng'];
     		return array(
          //'#markup' => $this->t('@phone is only shown if the subdivision is @subdivision!', array (
      		'#markup' => $this->t('Contact us on: @phone', array (
          '@phone' => $ph_no,
          //	'@subdivision' => $subdivision, 
        	)),
    		);
   		}
    else 
    	{
    	if(!empty($config['ph_no_sot']) && ($postcode == 'EH1') ) 
    		{
      		$ph_no = $config['ph_no_sot'];
     			return array(
      		  '#markup' => $this->t('Contact us on: @phone', array (
        	  '@phone' => $ph_no,
            //'@subdivision' => $subdivision, 
        	  )),
    			);
    		}
   		else
   			{
    			$ph_no = $config['ph_no_ire'];
     			return array(
					'#markup' => $this->t('Contact us on: @phone', array (
					'@phone' => $ph_no,
					//	'@subdivision' => $subdivision, 
						)
					),
				);
    	}
		}
  }
}
?>