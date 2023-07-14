<?php

namespace Hakger\Paxi;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * PBAInterface - xmlrpc lib
 *
 * @author Hubert Kowalski
 */
class PBAInterface implements LoggerAwareInterface
{
    // configuration

    /**
     * @var string ip, port and directory for pba connectin
     */
    private $rpc_url; // = 'http://192.168.128.78:5224/RPC2';

    /**
     * @var XMLRPCClient main xmlrpc client.
     */
    private $xml_client;

    /**
     * @var string language code
     */
    private $lang;

    /**
     * The logger instance.
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Sets a logger.
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __construct($url = '', LoggerInterface $logger = null)
    {
        if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL) !== false) {
            $this->rpc_url = $url;
            $this->xml_client = new XMLRPCClient(
                $this->rpc_url,
                '',
                false,
                $logger
            );
        }
        $this->logger = $logger;
        $this->lang = 'en';
    }

    public function setUrl($url)
    {
        if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL) !== false) {
            $this->xml_client = new XMLRPCClient(
                $this->rpc_url,
                '',
                false,
                $this->logger
            );
        } else {
            throw new PAException("URL '$url' is invalid!");
        }
    }

    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    private function checkCnt(&$params, $min_cnt)
    {
        if (count($params) < $min_cnt) {
            throw new PAException("Too little params count," .
            " needs at least $min_cnt");
        }
    }

    public function addAccount(array $params = array())
    {
        $min_cnt = 62;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'AccountAdd_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }
    
    public function rebuildNotification(array $params = array())
    {
        $min_cnt = 2;
        $this->checkCnt($params, $min_cnt);
        $request = array(
           'Server' => 'MESSAGE',
           'Method' => 'RebuildNotification',
           'Lang' => $this->lang,
           'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }
           
    public function adjustAccountBalance(array $params = array())
    {
        $min_cnt = 2;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'AccountBalanceAdjust_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function addAccountMember(array $params = array())
    {
        $min_cnt = 23;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'UserAdd_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function delAccountMember(array $params = array())
    {
        $min_cnt = 1;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'UserRemove_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function updateAccount(array $params = array())
    {
        $min_cnt = 46;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'AccountUpdate_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function updateAccountMember(array $params = array())
    {
        $min_cnt = 20;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'UserUpdate_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getAccountDetails(array $params = array())
    {
        $min_cnt = 1;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'AccountDetailsGet_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getPayMethods(array $params = array())
    {
        $min_cnt = 1;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'PayToolListForAccountGet_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getAccountDetailsEx(array $params = array())
    {
        $min_cnt = 1;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'AccountDetailsGetEx_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getExtendedAccountDetails(array $params = array())
    {
        $min_cnt = 1;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'AccountExtendedDetailsGet_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getAccountUsersList(array $params = array())
    {
        $min_cnt = 2;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'GetUsersListForAccount_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getUserDetails(array $params = array())
    {
        $min_cnt = 1;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'UserDetailsGet_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function addPEMSubscription(array $params = array())
    {
        $min_cnt = 19;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'PEMGATE',
            'Method' => 'AddPEMSubscription_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function addDomainSubscription(array $params = array())
    {
        $min_cnt = 30;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'DOMAINGATE',
            'Method' => 'DomainSubscrAdd_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }
    
    public function addDomainExtData(array $params = array())
    {
        $min_cnt = 3;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'DOMAINGATE',
            'Method' => 'DomainExtDataAdd_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function addPEMDomainForSubscription(array $params = array())
    {
        $min_cnt = 2;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'PEMGATE',
            'Method' => 'AddPEMDomainForSubscription_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function updateObjAttrList(array $params = array())
    {
        $min_cnt = 4;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'UpdateObjAttrList_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }
    
    public function getObjAttrList(array $params = array())
    {
        $min_cnt = 3;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'GetObjAttrList_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getPlanCategoryList(array $params = array())
    {
        $min_cnt = 2;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'PlanCategoryListGet_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getSalesCategoryList(array $params = array())
    {
        $min_cnt = 2;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'SalesCategoryListGet_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getPlanDetails(array $params = array())
    {
        $min_cnt = 1;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'PlanDetailsGet_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getSubscriptionDetails(array $params = array())
    {
        $min_cnt = 1;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'SubscriptionDetailsGet_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function cancelAllSubsForAccount(array $params = array())
    {
        $min_cnt = 4;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'CancelAllSubscriptionsForAccount_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function cancelSubscription(array $params = array())
    {
        $min_cnt = 4;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'PlaceSubscriptionCancellationOrder_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function cancelAccount(array $params = array())
    {
        $min_cnt = 3;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'BM',
            'Method' => 'PlaceAccountCancellationOrder_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    //domaingate functions

    public function getDomainPlanList(array $params = array())
    {
        $min_cnt = 3;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'DOMAINGATE',
            'Method' => 'DomainPlanListAvailableGet_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function checkSingleDomainAvailability(array $params = array())
    {
        $min_cnt = 5;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'DOMAINGATE',
            'Method' => 'SingleDomainNameAvailability_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function checkMultipleDomainAvailability(array $params = array())
    {
        $min_cnt = 4;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'DOMAINGATE',
            'Method' => 'DomainNamesAvailability_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getDomainPlanDetails(array $params = array())
    {
        $min_cnt = 1;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'DOMAINGATE',
            'Method' => 'DomainPlanGet_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getDomainPlanPeriods(array $params = array())
    {
        $min_cnt = 2;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'DOMAINGATE',
            'Method' => 'DomainPlanPeriodListGet_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getDomainInfo(array $params = array())
    {
        $min_cnt = 1;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'DOMAINGATE',
            'Method' => 'DomainInfoGet_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getFullDomainZoneList(array $params=array())
    {
        $min_cnt = 2;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'DOMAINGATE',
            'Method' => 'GetFullDomainZoneList_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function getDomainTransferKeyIsRequired(array $params = array())
    {
        $min_cnt = 1;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'DOMAINGATE',
            'Method' => 'DomainTransferKeyIsRequired_API',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    // KAGATE - For Key Account Manager

    public function addKAAddon(array $params = array())
    {
        $min_cnt = 2;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'KAGATE',
            'Method' => 'KA_AddonAdd',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function removeKAAddon(array $params = array())
    {
        $min_cnt = 2;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'KAGATE',
            'Method' => 'KA_AddonMoveToArc',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function addKAFeatureGroup(array $params = array())
    {
        $min_cnt = 4;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'KAGATE',
            'Method' => 'KA_FeatureGroupAdd',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function removeKAFeatureGroup(array $params = array())
    {
        $min_cnt = 1;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'KAGATE',
            'Method' => 'KA_FeatureGroupMoveToArc',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function addKAUpgrade(array $params = array())
    {
        $min_cnt = 6;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'KAGATE',
            'Method' => 'KA_UpgradeAdd',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }

    public function removeKAUpgrade(array $params = array())
    {
        $min_cnt = 2;
        $this->checkCnt($params, $min_cnt);
        $request = array(
            'Server' => 'KAGATE',
            'Method' => 'KA_UpgradeMoveToArc',
            'Lang' => $this->lang,
            'Params' => $params,
        );
        return $this->xml_client->Execute($request);
    }
}
