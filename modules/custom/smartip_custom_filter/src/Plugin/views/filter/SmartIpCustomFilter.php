<?php

namespace Drupal\smartip_custom_filter\Plugin\views\filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\filter\StringFilter;
use Drupal\smart_ip\SmartIpLocation; 

/**
 * Filter by start and end date.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("smartip_custom_filter")
 */
class SmartIpCustomFilter extends StringFilter {

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['turn_on_flag'] = ['default' => true];

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $form['turn_on_flag'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Filter using Smart IP location data.'),
      '#description' => $this->t('Filter Commerce Shops output data based on users country code and Shops billing countries field.'),
      '#default_value' => $this->options['turn_on_flag'],
      '#required' => FALSE,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    $this->ensureMyTable();

    /** @var \Drupal\views\Plugin\views\query\Sql $query */
    /** @var \Drupal\smart_ip\SmartIpLocation $location */

    $query = $this->query;
    $table = array_key_first($query->tables);
    $location = \Drupal::service('smart_ip.smart_ip_location');
    $country_code = $location->get('countryCode');

    $configuration = [
      'type' => 'INNER',
      'table' => 'commerce_store__billing_countries',
      'field' => 'entity_id',
      'left_table' => $table,
      'left_field' => 'store_id',
      'operator' => '=',
    ];

   
    $query->queueTable('commerce_store__billing_countries', $table, NULL , 'commerce_store__billing_countries');
    
  //Basic functionality without extra JOIN.
    //  $query->addWhere($this->options['group'], $table . '.address__country_code', $country_code, '=');
    
  //Get info from extra Joined table 
      $query->addWhere($this->options['group'], 'commerce_store__billing_countries' . '.billing_countries_value', $country_code, '=');

  //Sort items/ !not supported yet in D9 version
     // $query->orderRandom();
  }

}
