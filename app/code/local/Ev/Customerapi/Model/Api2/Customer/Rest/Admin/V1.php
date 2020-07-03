<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * API2 for catalog_product (Admin)
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Ev_Customerapi_Model_Api2_Customer_Rest_Admin_V1 extends Mage_Customer_Model_Api2_Customer_Rest
{
    /**
     * Get customers list
     *
     * @return array
     */
    protected function _retrieveCollection()
    {
        $data = Mage::getResourceModel('customer/customer_collection')
            ->addNameToSelect()
            ->addAttributeToSelect('gender')
            ->joinAttribute('street', 'customer_address/street', 'default_billing', null, 'left')
            ->joinAttribute('region', 'customer_address/region', 'default_billing', null, 'left')
            ->joinAttribute('city', 'customer_address/city', 'default_billing', null, 'left')
            ->joinAttribute('postcode', 'customer_address/postcode', 'default_billing', null, 'left')
            ->joinAttribute('country_id', 'customer_address/country_id', 'default_billing', null, 'left')
            ->joinAttribute('telephone', 'customer_address/telephone', 'default_billing', null, 'left')
            ->load();
        $data = $data->toArray();
        return isset($data['items']) ? $data['items'] : $data;
    }
}
