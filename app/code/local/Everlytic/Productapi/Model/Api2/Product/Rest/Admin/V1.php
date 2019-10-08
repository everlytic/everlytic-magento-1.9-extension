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
class Everlytic_Productapi_Model_Api2_Product_Rest_Admin_V1 extends Mage_Catalog_Model_Api2_Product_Rest
{
    /**
     * The greatest decimal value which could be stored. Corresponds to DECIMAL (12,4) SQL type
     */
    const MAX_DECIMAL_VALUE = 99999999.9999;

    /**
     * Add special fields to product get response
     *
     * @param Mage_Catalog_Model_Product $product
     */
    protected function _prepareProductForResponse(Mage_Catalog_Model_Product $product)
    {
        $productData = $product->getData();
        $productData['price'] = strip_tags(Mage::helper('core')->currency($product->getPrice()));
        $productData['gallery'] = $this->getGalleryFromProduct($product);
        $productData['product_url'] = $product->getProductUrl();
        $productData['add_to_cart_url'] = Mage::getBaseUrl() . "add-to-cart/index/index/product/" . $product->getId();

        $product->addData($productData);
    }

    /**
     * Retrieve list of products
     *
     * @return array
     */
    protected function _retrieveCollection()
    {
        /** @var $collection Mage_Catalog_Model_Resource_Product_Collection */
        $collection = Mage::getResourceModel('catalog/product_collection');
        $collection->addAttributeToSelect(array_keys(
            $this->getAvailableAttributes($this->getUserType(), Mage_Api2_Model_Resource::OPERATION_ATTRIBUTE_READ)
        ));
        $products = $collection->load();

        foreach ($products as $product) {
            $this->_prepareProductForResponse($product);
        }

        return $products->toArray();
    }

    /**
     * @param Mage_Catalog_Model_Product $product
     * @return array
     */
    private function getGalleryFromProduct(Mage_Catalog_Model_Product $product)
    {
        $gallery = [];
        $galleryImages = Mage::getModel('catalog/product')->load($product->getId())->getMediaGalleryImages();
        foreach ($galleryImages as $_image) {
            $gallery[] = $_image->getUrl();
        }
        return $gallery;
    }
}
