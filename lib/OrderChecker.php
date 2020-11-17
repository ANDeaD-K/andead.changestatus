<?php
namespace Andead\ChangeStatus;

use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Bitrix\Sale\Order;

class OrderChecker
{
    public static $MODULE_ID = 'andead.changestatus';
    public static $MODULE_AGENT_FUNCTION = '\Andead\ChangeStatus\OrderChecker::CheckOrders();';

    public static function CheckOrders()
    {
        $agentChangeHour = Option::get(self::$MODULE_ID, 'AGENT_CHANGE_HOUR');
        $orderCheckCount = Option::get(self::$MODULE_ID, 'ORDER_CHECK_COUNT');
        $orderDateUpdate = Option::get(self::$MODULE_ID, 'ORDER_DATE_UPDATE');
        $orderStopPayed = Option::get(self::$MODULE_ID, 'ORDER_STOP_PAYED');
        $orderStopCanceled = Option::get(self::$MODULE_ID, 'ORDER_STOP_CANCELED');

		if (date('H') == $agentChangeHour) {
			if (Loader::includeModule('sale')) {
				
				for ($i = 1; $i <= 4; $i++) {
					if (!empty(Option::get(self::$MODULE_ID, 'ORDER_CHANGE_STATUS_'.$i))) {
						$arFilter = [];
						$arFilter['STATUS_ID'] = Option::get(self::$MODULE_ID, 'ORDER_CHANGE_STATUS_'.$i);

						if (!empty($orderDateUpdate)) {
							$arFilter['<=DATE_UPDATE'] = date('d.m.Y H:i:s', time() - ($orderDateUpdate * 60));
						}

						if ($orderStopPayed == 'Y') {
							$arFilter['PAYED'] = 'N';
						}

						if ($orderStopCanceled == 'Y') {
							$arFilter['CANCELED'] = 'N';
						}

						$arRes = Order::getList([
							'select' => ['ID', 'CANCELED'],
							'filter' => $arFilter,
							'order' => ['DATE_UPDATE' => 'ASC'],
							'limit' => $orderCheckCount,
						])->fetchAll();

						if (!empty($arRes)) {
							foreach ($arRes as $value) {
								\CSaleOrder::StatusOrder($value['ID'], Option::get(self::$MODULE_ID, 'ORDER_CHANGE_STATUS_TO_'.$i));
							}
						}

						unset($arFilter, $arRes);
					}
				}
			}
		}

        return self::$MODULE_AGENT_FUNCTION;
    }
}

?>