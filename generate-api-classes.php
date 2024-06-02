<?php

$endpoints = [
    'account',
    'accountingPeriod',
    'advIntercompanyJournalEntry',
    'assemblyBuild',
    'assemblyItem',
    'assemblyUnbuild',
    'billingAccount',
    'billingRevenueEvent',
    'billingSchedule',
    'bin',
    'binTransfer',
    'blanketPurchaseOrder',
    'bom',
    'bomRevision',
    'calendarEvent',
    'campaign',
    'campaignResponse',
    'cashRefund',
    'cashSale',
    'charge',
    'check',
    'classification',
    'commerceCategory',
    'competitor',
    'consolidatedExchangeRate',
    'contact',
    'contactCategory',
    'contactRole',
    'costCategory',
    'couponCode',
    'creditCardCharge',
    'creditCardRefund',
    'creditMemo',
    'currency',
    'customer',
    'customerCategory',
    'customerDeposit',
    'customerMessage',
    'customerPayment',
    'customerRefund',
    'customerStatus',
    'customerSubsidiaryRelationship',
    'department',
    'deposit',
    'depositApplication',
    'descriptionItem',
    'discountItem',
    'downloadItem',
    'emailTemplate',
    'employee',
    'estimate',
    'expenseCategory',
    'expenseReport',
    'fairValuePrice',
    'fulfillmentRequest',
    'giftCertificateItem',
    'inboundShipment',
    'intercompanyJournalEntry',
    'intercompanyTransferOrder',
    'inventoryAdjustment',
    'inventoryCostRevaluation',
    'inventoryCount',
    'inventoryItem',
    'inventoryNumber',
    'inventoryTransfer',
    'invoice',
    'issue',
    'itemFulfillment',
    'itemGroup',
    'itemReceipt',
    'itemRevision',
    'job',
    'jobStatus',
    'jobType',
    'journalEntry',
    'kitItem',
    'location',
    'manufacturingCostTemplate',
    'manufacturingOperationTask',
    'manufacturingRouting',
    'markupItem',
    'message',
    'nexus',
    'nonInventoryPurchaseItem',
    'nonInventoryResaleItem',
    'nonInventorySaleItem',
    'noteType',
    'opportunity',
    'otherChargePurchaseItem',
    'otherChargeResaleItem',
    'otherChargeSaleItem',
    'otherName',
    'otherNameCategory',
    'partner',
    'paycheck',
    'paymentItem',
    'paymentMethod',
    'phoneCall',
    'priceBook',
    'priceLevel',
    'pricePlan',
    'pricingGroup',
    'projectTask',
    'promotionCode',
    'purchaseContract',
    'purchaseOrder',
    'purchaseRequisition',
    'returnAuthorization',
    'revRecSchedule',
    'revRecTemplate',
    'salesOrder',
    'salesRole',
    'salesTaxItem',
    'servicePurchaseItem',
    'serviceResaleItem',
    'serviceSaleItem',
    'shipItem',
    'statisticalJournalEntry',
    'subscription',
    'subscriptionChangeOrder',
    'subscriptionLine',
    'subscriptionPlan',
    'subscriptionTerm',
    'subsidiary',
    'subtotalItem',
    'supportCase',
    'task',
    'taxType',
    'term',
    'timeBill',
    'timeSheet',
    'topic',
    'transferOrder',
    'unitsType',
    'usage',
    'vendor',
    'vendorBill',
    'vendorCategory',
    'vendorCredit',
    'vendorPayment',
    'vendorPrepayment',
    'vendorPrepaymentApplication',
    'vendorReturnAuthorization',
    'vendorSubsidiaryRelationship',
    'webSite',
    'workOrder',
    'workOrderClose',
    'workOrderCompletion',
    'workOrderIssue',
];

function genClass($endpoint) {

    $className = ucfirst($endpoint);
    $template = <<<TEMPLATE
<?php

namespace NetsuiteRestApi\Api;

class {$className} extends Base
{
    const PATH = "/{$endpoint}";
}

TEMPLATE;

    $file = __DIR__ . '/src/Api/' . $className . '.php';
    file_put_contents($file, $template);
//    exit;
}

function generateApiClasses(array $endpoints) {
    foreach ($endpoints as $endpoint) {
        genClass($endpoint);
    }
}

function outputClientProps(array $endpoints) {
    foreach ($endpoints as $endpoint) {
        echo sprintf('public readonly Api\\%s $%s,', ucfirst($endpoint), $endpoint);
        echo PHP_EOL;
    }
}

function outputFactoryProps(array $endpoints) {
    foreach ($endpoints as $endpoint) {
        echo sprintf('new Api\\%s($httpClient, $pageFactory),', ucfirst($endpoint));
        echo PHP_EOL;
    }
}

//generateApiClasses($endpoints);
outputClientProps($endpoints);
//outputFactoryProps($endpoints);
