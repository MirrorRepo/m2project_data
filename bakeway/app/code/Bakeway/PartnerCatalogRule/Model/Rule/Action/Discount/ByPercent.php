<?php
namespace Bakeway\PartnerCatalogRule\Model\Rule\Action\Discount;

class ByPercent extends \Magento\SalesRule\Model\Rule\Action\Discount\ByPercent
{
    /**
     * @param \Magento\SalesRule\Model\Rule $rule
     * @param \Magento\Quote\Model\Quote\Item\AbstractItem $item
     * @param float $qty
     * @param float $rulePercent
     * @return Data
     */
    protected function _calculate($rule, $item, $qty, $rulePercent)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/discountData.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $logger->info('--------- Calculate Discount File ---------------------');

        $totalDiscountAmount = 0;
        $quote = $item->getQuote();
        foreach ($quote->getAllItems() as $innerItem) {
            $totalDiscountAmount = $totalDiscountAmount + $innerItem->getDiscountAmount();

        $logger->info('--------- Total Discount Amount '.$item->getProduct()->getName().' DiscountAmount : '.$totalDiscountAmount.' ---------------------');

        $logger->info('--------- Item '.$item->getProduct()->getName().' DiscountAmount : '.$innerItem->getDiscountAmount().' ---------------------');
        }
        $logger->info('--------- totalDiscountAmount : '.$totalDiscountAmount.' ---------------------');
        /** @var \Magento\SalesRule\Model\Rule\Action\Discount\Data $discountData */
        $discountData = $this->discountFactory->create();
        $maxDiscountAmount = $rule->getData('max_discount_amount');
         
        if ($totalDiscountAmount >= $maxDiscountAmount) {
            $logger->info('--------- Comes inside condition ---------------------');
            return $discountData;
        }

        $itemPrice = $this->validator->getItemPrice($item);
        $baseItemPrice = $this->validator->getItemBasePrice($item);
        $itemOriginalPrice = $this->validator->getItemOriginalPrice($item);
        $baseItemOriginalPrice = $this->validator->getItemBaseOriginalPrice($item);

        $_rulePct = $rulePercent / 100;
        $amount = ($qty * $itemPrice - $item->getDiscountAmount()) * $_rulePct;
        $baseAmount = ($qty * $baseItemPrice - $item->getBaseDiscountAmount()) * $_rulePct;
        $originalAmount = ($qty * $itemOriginalPrice - $item->getDiscountAmount()) * $_rulePct;
        $baseOriginalAmount = ($qty * $baseItemOriginalPrice - $item->getBaseDiscountAmount()) * $_rulePct;

        $logger->info('--------- Amount : '.$amount.' ---------------------');
        $logger->info('--------- baseAmount : '.$baseAmount.' ---------------------');
        $logger->info('--------- originalAmount : '.$originalAmount.' ---------------------');
        $logger->info('--------- baseOriginalAmount : '.$baseOriginalAmount.' ---------------------');
        $logger->info('--------- maxDiscountAmount : '.$maxDiscountAmount.' ---------------------');
        $logger->info('=========================================================');

        if (($amount+$totalDiscountAmount) > $maxDiscountAmount) 
        {
            $amount = ($maxDiscountAmount-$totalDiscountAmount);
        }
        if (($baseAmount+$totalDiscountAmount) > $maxDiscountAmount) 
        {
            $baseAmount = ($maxDiscountAmount-$totalDiscountAmount);
        }
        if (($originalAmount+$totalDiscountAmount) > $maxDiscountAmount)
        {
            $originalAmount = ($maxDiscountAmount-$totalDiscountAmount);
        }
        if (($baseOriginalAmount+$totalDiscountAmount) > $maxDiscountAmount)
        {
            $baseOriginalAmount = ($maxDiscountAmount-$totalDiscountAmount);
        }

        $discountData->setAmount($amount);
        $discountData->setBaseAmount($baseAmount);
        $discountData->setOriginalAmount($originalAmount);
        $discountData->setBaseOriginalAmount($baseOriginalAmount);

        if (!$rule->getDiscountQty() || $rule->getDiscountQty() > $qty) {
            $discountPercent = min(100, $item->getDiscountPercent() + $rulePercent);
            $item->setDiscountPercent($discountPercent);
        }

        return $discountData;
    }
}