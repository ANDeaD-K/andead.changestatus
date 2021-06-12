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
        $orderCheckCount = Option::get(self::$MODULE_ID, 'ORDER_CHECK_COUNT');
        $orderStopPayed = Option::get(self::$MODULE_ID, 'ORDER_STOP_PAYED');
        $orderStopCanceled = Option::get(self::$MODULE_ID, 'ORDER_STOP_CANCELED');

		if (Loader::includeModule('sale')) {
			for ($i = 1; $i <= 8; $i++) {
				if (date('H') == Option::get(self::$MODULE_ID, 'AGENT_CHANGE_HOUR_'.$i)) {
					if (!empty(Option::get(self::$MODULE_ID, 'ORDER_CHANGE_STATUS_'.$i))) {
						
						$arFilter = [];
						$arFilter['STATUS_ID'] = Option::get(self::$MODULE_ID, 'ORDER_CHANGE_STATUS_'.$i);
						
						if (Option::get(self::$MODULE_ID, 'LATEST_DATE_ENABLED_'.$i) == 'Y') {
							$arFilter['=SALE_INTERNALS_ORDER_PROPERTY_CODE'] = 'LATEST_DATE';
							$arFilter['=SALE_INTERNALS_ORDER_PROPERTY_VALUE'] = date('d.m.Y');
						}

						if (!empty(Option::get(self::$MODULE_ID, 'ORDER_DATE_UPDATE_'.$i))) {
							$arFilter['<=DATE_UPDATE'] = date('d.m.Y H:i:s', time() - (Option::get(self::$MODULE_ID, 'ORDER_DATE_UPDATE_'.$i) * 60));
						}

						if ($orderStopPayed == 'Y') {
							$arFilter['PAYED'] = 'N';
						}

						if ($orderStopCanceled == 'Y') {
							$arFilter['CANCELED'] = 'N';
						}

						$arRes = Order::getList([
							'select' => ['ID', 'CANCELED', 'PROPERTY'],
							'filter' => $arFilter,
							'order' => ['DATE_UPDATE' => 'ASC'],
							'limit' => $orderCheckCount,
							'runtime' => [
								new \Bitrix\Main\Entity\ReferenceField(
									'PROPERTY',
									'\Bitrix\Sale\Internals\OrderPropsValueTable',
									[
										'=this.ID' => 'ref.ORDER_ID',
									]
								)
							]
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