<?php

namespace Brands\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;

use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\Template\Loop\Argument\Argument;

use Thelia\Model\CountryQuery;

/**
 *
 * Brands loop
 *
 *
 * Class Brands
 * @package Thelia\Core\Template\Loop
 * @author Flavien Grenier - Nicolas Villa nicolas@libre-shop.com
 */
class BrandsLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{
    protected $timestampable = true;

    /**
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id'),
            Argument::createIntListTypeArgument('name'),
        );
    }

    public function buildModelCriteria()
    {
        $search = CountryQuery::create();

        /* manage translations */
        $this->configureI18nProcessing($search);

        $id = $this->getId();

        if (null !== $id) {
            $search->filterById($id, Criteria::IN);
        }

        $area = $this->getArea();

        if (null !== $area) {
            $search->filterByAreaId($area, Criteria::IN);
        }

        $withArea = $this->getWith_area();

        if (true === $withArea) {
            $search->filterByAreaId(null, Criteria::ISNOTNULL);
        } elseif (false === $withArea) {
            $search->filterByAreaId(null, Criteria::ISNULL);
        }

        $exclude = $this->getExclude();

        if (!is_null($exclude)) {
            $search->filterById($exclude, Criteria::NOT_IN);
        }

        $search->addAscendingOrderByColumn('i18n_TITLE');

        return $search;

    }

    public function parseResults(LoopResult $loopResult)
    {
        foreach ($loopResult->getResultDataCollection() as $brand) {
            $loopResultRow = new LoopResultRow($brand);
            $loopResultRow->set("ID", $brand->getId())
                ->set("NAME",$country->getVirtualColumn('NAME'))
            ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;

    }
}
