<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\PageDesigner\Model\Source;

use Magenerds\PageDesigner\Constants;
use Magento\Catalog\Model\Category\Attribute\Source\Page;
use Magento\Cms\Model\Block as CmsBlock;
use Magento\Cms\Model\ResourceModel\Block\Collection;

/**
 * Class Block
 *
 * @package     Magenerds\PageDesigner\Model\Source
 * @file        Block.php
 * @copyright   Copyright (c) 2019 TechDivision GmbH (https://www.techdivision.com)
 * @site        https://www.techdivision.com/
 * @author      Simon Sippert <s.sippert@techdivision.com>
 */
class Block extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getAllOptions()
    {
        // check previously defined options
        if (!$this->_options) {
            /** @var $collection Collection */
            /** @noinspection PhpUndefinedMethodInspection */
            $collection = $this->_blockCollectionFactory->create();

            // only display blocks which have a page designer attached
            $collection->addFieldToFilter(Constants::ATTR_PAGE_DESIGNER_JSON, ['notnull' => true])->load();

            // reset options
            $this->_options = [[
                'value' => '',
                'label' => __('Please select a page designer block to import...'),
            ]];

            /** @var $entry CmsBlock */
            foreach ($collection as $entry) {
                // add to options
                $this->_options[] = [
                    'value' => $entry->getData(Constants::ATTR_PAGE_DESIGNER_JSON),
                    'label' => $entry->getData('title'),
                ];
            }
        }

        // return options
        return $this->_options;
    }
}
