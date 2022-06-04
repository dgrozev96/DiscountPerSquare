<?php

use Shopware\Components\CSRFWhitelistAware;
use Shopware\Models\Article\Detail;
use Shopware\Models\Article\Price;
use Shopware\Models\Article\Article;
use Shopware\Models\Config\Form;


class Shopware_Controllers_Backend_DiscountPerSquareModulePlainHtml extends Enlight_Controller_Action implements CSRFWhitelistAware
{

    public function indexAction()
    {

    }

    public function getWhitelistedCSRFActions(): array
    {
        return ['index', 'generate', 'delete'];
    }

    /**
     * @throws Exception
     */
    public function generateAction()
    {
        $configData = $this->getConfig();
        $this->Front()->Plugins()->ViewRenderer()->setNoRender();
        /** @var  Detail $articles */
        $articles = $this->getModelManager()->getRepository(Detail::class)->findBy(['unit' => 10]);
        foreach ($articles as $articleDetail) {
            foreach ($articleDetail->getPrices()->toArray() as $priceGroup) {
                if (array_key_exists($priceGroup->getCustomerGroup()->getKey(),$configData)) {
                    $collection = [
                        'from' => ceil(100 / $articleDetail->getPurchaseUnit()),
                        'to' => 'beliebig',
                        'article' => $this->getModelManager()->getRepository(Article::class)->find($articleDetail->getArticleId()),
                        'articledetailsID' => $articleDetail->getId(),
                        'price' => $priceGroup->getPrice() - round((($priceGroup->getPrice() * $configData[$priceGroup->getCustomerGroup()->getKey()]['amount']) / 100), 2),
                        'pseudoprice' => $priceGroup->getPseudoPrice(),
                        'percent' => $configData[$priceGroup->getCustomerGroup()->getKey()]['amount']
                    ];
                        /* @var Price $newPrrice */
                        $newPrice = new Price();
                        $newPrice->setCustomerGroup($priceGroup->getCustomerGroup());
                        $newPrice->setFrom($collection['from']);
                        $newPrice->setTo($collection['to']);
                        $newPrice->setArticle($collection['article']);
                        $newPrice->setDetail($articleDetail);
                        $newPrice->setPrice($collection['price']);
                        $newPrice->setPseudoPrice($collection['pseudoprice']);
                        $newPrice->setPercent($collection['percent']);
                        $this->getModelManager()->persist($newPrice);
                        $this->getModelManager()->flush();

                }
            }
        }


        echo json_encode(true);
        exit;

    }

    public function deleteAction()
    {

        $res = Shopware()->Db()->query("
        DELETE
FROM
	s_articles_prices
WHERE
	s_articles_prices.`from` > 1

            ");

        echo json_encode(['result' => $res]);
        exit;

    }

    /**
     * @return array
     */
    private function getConfig(): array
    {
        $connection = $this->container->get('dbal_connection');
        $configData = [];

        $sql = 'SELECT
	s_core_customergroups.groupkey
FROM
	s_core_config_values
	INNER JOIN
	s_core_customergroups
WHERE
	s_core_config_values.element_id = 1139 AND
	REGEXP_SUBSTR(s_core_config_values.`value`,"[0-9]+") = s_core_customergroups.id
	';
        $handleGroups = $connection->fetchAll($sql, [':active' => true]);
        $configs = Shopware()->Models()->getRepository(Form::class)->findBy(['name' => 'DiscountPerSquare']);
        foreach ($configs as $config) {

            foreach ($config->getElements()->toArray() as $element) {
                foreach ($element->getValues()->toArray() as $value) {
                    foreach ($handleGroups as $handlerGroupKey) {
                        $customerGroupKey = $value->getShop()->getCustomerGroup()->getKey();

                        if ($element->getName() == 'value' || $element->getName() == 'amount' || $element->getName() == 'unit') {
                            $configData[$customerGroupKey][$element->getName()] = $value->getValue();

                        } else {
                            $trimmed = rtrim($element->getName(), "H");
                            $configData[$handlerGroupKey['groupkey']][$trimmed] = $value->getValue();
                        }
                    }
                }


            }
        }

        return $configData;
    }



}