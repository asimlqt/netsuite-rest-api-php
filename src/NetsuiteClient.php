<?php

namespace NetsuiteRestApi;

class NetsuiteClient
{
    public function __construct(
        public readonly Api\Query $query,
        public readonly Api\Account $account,
        public readonly Api\AccountingPeriod $accountingPeriod,
        public readonly Api\AdvIntercompanyJournalEntry $advIntercompanyJournalEntry,
        public readonly Api\AssemblyBuild $assemblyBuild,
        public readonly Api\AssemblyItem $assemblyItem,
        public readonly Api\AssemblyUnbuild $assemblyUnbuild,
        public readonly Api\BillingAccount $billingAccount,
        public readonly Api\BillingRevenueEvent $billingRevenueEvent,
        public readonly Api\BillingSchedule $billingSchedule,
        public readonly Api\Bin $bin,
        public readonly Api\BinTransfer $binTransfer,
        public readonly Api\BlanketPurchaseOrder $blanketPurchaseOrder,
        public readonly Api\Bom $bom,
        public readonly Api\BomRevision $bomRevision,
        public readonly Api\CalendarEvent $calendarEvent,
        public readonly Api\Campaign $campaign,
        public readonly Api\CampaignResponse $campaignResponse,
        public readonly Api\CashRefund $cashRefund,
        public readonly Api\CashSale $cashSale,
        public readonly Api\Charge $charge,
        public readonly Api\Check $check,
        public readonly Api\Classification $classification,
        public readonly Api\CommerceCategory $commerceCategory,
        public readonly Api\Competitor $competitor,
        public readonly Api\ConsolidatedExchangeRate $consolidatedExchangeRate,
        public readonly Api\Contact $contact,
        public readonly Api\ContactCategory $contactCategory,
        public readonly Api\ContactRole $contactRole,
        public readonly Api\CostCategory $costCategory,
        public readonly Api\CouponCode $couponCode,
        public readonly Api\CreditCardCharge $creditCardCharge,
        public readonly Api\CreditCardRefund $creditCardRefund,
        public readonly Api\CreditMemo $creditMemo,
        public readonly Api\Currency $currency,
        public readonly Api\Customer $customer,
        public readonly Api\CustomerCategory $customerCategory,
        public readonly Api\CustomerDeposit $customerDeposit,
        public readonly Api\CustomerMessage $customerMessage,
        public readonly Api\CustomerPayment $customerPayment,
        public readonly Api\CustomerRefund $customerRefund,
        public readonly Api\CustomerStatus $customerStatus,
        public readonly Api\CustomerSubsidiaryRelationship $customerSubsidiaryRelationship,
        public readonly Api\Department $department,
        public readonly Api\Deposit $deposit,
        public readonly Api\DepositApplication $depositApplication,
        public readonly Api\DescriptionItem $descriptionItem,
        public readonly Api\DiscountItem $discountItem,
        public readonly Api\DownloadItem $downloadItem,
        public readonly Api\EmailTemplate $emailTemplate,
        public readonly Api\Employee $employee,
        public readonly Api\Estimate $estimate,
        public readonly Api\ExpenseCategory $expenseCategory,
        public readonly Api\ExpenseReport $expenseReport,
        public readonly Api\FairValuePrice $fairValuePrice,
        public readonly Api\FulfillmentRequest $fulfillmentRequest,
        public readonly Api\GiftCertificateItem $giftCertificateItem,
        public readonly Api\InboundShipment $inboundShipment,
        public readonly Api\IntercompanyJournalEntry $intercompanyJournalEntry,
        public readonly Api\IntercompanyTransferOrder $intercompanyTransferOrder,
        public readonly Api\InventoryAdjustment $inventoryAdjustment,
        public readonly Api\InventoryCostRevaluation $inventoryCostRevaluation,
        public readonly Api\InventoryCount $inventoryCount,
        public readonly Api\InventoryItem $inventoryItem,
        public readonly Api\InventoryNumber $inventoryNumber,
        public readonly Api\InventoryTransfer $inventoryTransfer,
        public readonly Api\Invoice $invoice,
        public readonly Api\Issue $issue,
        public readonly Api\ItemFulfillment $itemFulfillment,
        public readonly Api\ItemGroup $itemGroup,
        public readonly Api\ItemReceipt $itemReceipt,
        public readonly Api\ItemRevision $itemRevision,
        public readonly Api\Job $job,
        public readonly Api\JobStatus $jobStatus,
        public readonly Api\JobType $jobType,
        public readonly Api\JournalEntry $journalEntry,
        public readonly Api\KitItem $kitItem,
        public readonly Api\Location $location,
        public readonly Api\ManufacturingCostTemplate $manufacturingCostTemplate,
        public readonly Api\ManufacturingOperationTask $manufacturingOperationTask,
        public readonly Api\ManufacturingRouting $manufacturingRouting,
        public readonly Api\MarkupItem $markupItem,
        public readonly Api\Message $message,
        public readonly Api\Nexus $nexus,
        public readonly Api\NonInventoryPurchaseItem $nonInventoryPurchaseItem,
        public readonly Api\NonInventoryResaleItem $nonInventoryResaleItem,
        public readonly Api\NonInventorySaleItem $nonInventorySaleItem,
        public readonly Api\NoteType $noteType,
        public readonly Api\Opportunity $opportunity,
        public readonly Api\OtherChargePurchaseItem $otherChargePurchaseItem,
        public readonly Api\OtherChargeResaleItem $otherChargeResaleItem,
        public readonly Api\OtherChargeSaleItem $otherChargeSaleItem,
        public readonly Api\OtherName $otherName,
        public readonly Api\OtherNameCategory $otherNameCategory,
        public readonly Api\Partner $partner,
        public readonly Api\Paycheck $paycheck,
        public readonly Api\PaymentItem $paymentItem,
        public readonly Api\PaymentMethod $paymentMethod,
        public readonly Api\PhoneCall $phoneCall,
        public readonly Api\PriceBook $priceBook,
        public readonly Api\PriceLevel $priceLevel,
        public readonly Api\PricePlan $pricePlan,
        public readonly Api\PricingGroup $pricingGroup,
        public readonly Api\ProjectTask $projectTask,
        public readonly Api\PromotionCode $promotionCode,
        public readonly Api\PurchaseContract $purchaseContract,
        public readonly Api\PurchaseOrder $purchaseOrder,
        public readonly Api\PurchaseRequisition $purchaseRequisition,
        public readonly Api\ReturnAuthorization $returnAuthorization,
        public readonly Api\RevRecSchedule $revRecSchedule,
        public readonly Api\RevRecTemplate $revRecTemplate,
        public readonly Api\SalesOrder $salesOrder,
        public readonly Api\SalesRole $salesRole,
        public readonly Api\SalesTaxItem $salesTaxItem,
        public readonly Api\ServicePurchaseItem $servicePurchaseItem,
        public readonly Api\ServiceResaleItem $serviceResaleItem,
        public readonly Api\ServiceSaleItem $serviceSaleItem,
        public readonly Api\ShipItem $shipItem,
        public readonly Api\StatisticalJournalEntry $statisticalJournalEntry,
        public readonly Api\Subscription $subscription,
        public readonly Api\SubscriptionChangeOrder $subscriptionChangeOrder,
        public readonly Api\SubscriptionLine $subscriptionLine,
        public readonly Api\SubscriptionPlan $subscriptionPlan,
        public readonly Api\SubscriptionTerm $subscriptionTerm,
        public readonly Api\Subsidiary $subsidiary,
        public readonly Api\SubtotalItem $subtotalItem,
        public readonly Api\SupportCase $supportCase,
        public readonly Api\Task $task,
        public readonly Api\TaxType $taxType,
        public readonly Api\Term $term,
        public readonly Api\TimeBill $timeBill,
        public readonly Api\TimeSheet $timeSheet,
        public readonly Api\Topic $topic,
        public readonly Api\TransferOrder $transferOrder,
        public readonly Api\UnitsType $unitsType,
        public readonly Api\Usage $usage,
        public readonly Api\Vendor $vendor,
        public readonly Api\VendorBill $vendorBill,
        public readonly Api\VendorCategory $vendorCategory,
        public readonly Api\VendorCredit $vendorCredit,
        public readonly Api\VendorPayment $vendorPayment,
        public readonly Api\VendorPrepayment $vendorPrepayment,
        public readonly Api\VendorPrepaymentApplication $vendorPrepaymentApplication,
        public readonly Api\VendorReturnAuthorization $vendorReturnAuthorization,
        public readonly Api\VendorSubsidiaryRelationship $vendorSubsidiaryRelationship,
        public readonly Api\WebSite $webSite,
        public readonly Api\WorkOrder $workOrder,
        public readonly Api\WorkOrderClose $workOrderClose,
        public readonly Api\WorkOrderCompletion $workOrderCompletion,
        public readonly Api\WorkOrderIssue $workOrderIssue
    ) {}
}