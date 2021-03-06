<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Internals\StatusLangTable;
use Bitrix\Sale\Internals\PaySystemActionTable;
use Bitrix\Sale\Delivery\Services\Table;
use Bitrix\Main\UI\Extension;

$MODULE_ID = 'andead.changestatus';
$MODULE_AGENT_FUNCTION = '\Andead\ChangeStatus\OrderChecker::CheckOrders();';

if ($USER->IsAdmin() || Loader::includeModule($MODULE_ID)) {
	if (Loader::IncludeModule('sale')) {
        $statusOrderResult = StatusLangTable::getList([
            'select' => [
                'STATUS_ID',
                'NAME',
                'DESCRIPTION',
            ],
            'filter' => [
                'STATUS.TYPE' => 'O',
                'LID' => LANGUAGE_ID,
            ],
            'order' => [
                'STATUS_ID' => 'ASC',
            ],
            'limit' => 30,
            'cache' => [
                'ttl' => 86400,
            ],
        ])->fetchAll();

        $paymentSystemResult = PaySystemActionTable::getList([
            'select' => [
                'ID',
                'NAME',
                'DESCRIPTION',
            ],
            'filter' => [
                'ACTIVE' => 'Y',
            ],
            'order' => [
                'ID' => 'ASC',
            ],
            'limit' => 30,
            'cache' => [
                'ttl' => 86400,
            ],
        ])->fetchAll();

        $deliverySystemResult = Table::getList([
            'select' => [
                'ID',
                'NAME',
                'DESCRIPTION',
            ],
            'filter' => [
                'ACTIVE' => 'Y',
            ],
            'order' => [
                'ID' => 'ASC',
            ],
            'limit' => 30,
            'cache' => [
                'ttl' => 86400,
            ],
        ])->fetchAll();
    }
	
	$arTabs = [
        [
            'DIV' => 'AgentOptions',
            'TAB' => 'Настройки модуля',
            'ICON' => 'ib_agent_options',
            'TITLE' => 'Настройки модуля',
        ]
    ];
    $tabControl = new CAdminTabControl("tabControl", $arTabs);
	
	$arOptions = [
        'AgentOptions' => [
            'ORDER_CHECK_COUNT' => [
                'TYPE' => 'number',
                'DEFAULT' => '10',
                'DESCRIPTION' => 'Количество заказов для проверки за 1 раз (шт.)',
                'HINT' => '',
                'HEADING' => '',
            ],
			'AGENT_CHANGE_HOUR_1' => [
                'TYPE' => 'number',
                'DEFAULT' => '18',
                'DESCRIPTION' => 'Час смены статуса',
                'HINT' => '',
                'HEADING' => 'Смена статуса 1',
            ],
			'ORDER_CHANGE_STATUS_1' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'При статусе заказа',
                'HINT' => '',
                'HEADING' => '',
            ],
            'ORDER_CHANGE_STATUS_TO_1' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Сменить статус заказа на',
                'HINT' => '',
                'HEADING' => '',
            ],
			'ORDER_DATE_UPDATE_1' => [
                'TYPE' => 'number',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять заказы, если с даты последнего обновления заказа прошло больше (мин.)',
                'HINT' => '',
                'HEADING' => '',
            ],
			'LATEST_DATE_ENABLED_1' => [
                'TYPE' => 'hidden',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять самую позднюю дату',
                'HINT' => '',
                'HEADING' => '',
            ],
			'AGENT_CHANGE_HOUR_2' => [
                'TYPE' => 'number',
                'DEFAULT' => '18',
                'DESCRIPTION' => 'Час смены статуса',
                'HINT' => '',
                'HEADING' => 'Смена статуса 2',
            ],
			'ORDER_CHANGE_STATUS_2' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'При статусе заказа',
                'HINT' => '',
                'HEADING' => '',
            ],
            'ORDER_CHANGE_STATUS_TO_2' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Сменить статус заказа на',
                'HINT' => '',
                'HEADING' => '',
            ],
			'ORDER_DATE_UPDATE_2' => [
                'TYPE' => 'number',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять заказы, если с даты последнего обновления заказа прошло больше (мин.)',
                'HINT' => '',
                'HEADING' => '',
            ],
			'LATEST_DATE_ENABLED_2' => [
                'TYPE' => 'hidden',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять самую позднюю дату',
                'HINT' => '',
                'HEADING' => '',
            ],
			'AGENT_CHANGE_HOUR_3' => [
                'TYPE' => 'number',
                'DEFAULT' => '18',
                'DESCRIPTION' => 'Час смены статуса',
                'HINT' => '',
                'HEADING' => 'Смена статуса 3',
            ],
			'ORDER_CHANGE_STATUS_3' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'При статусе заказа',
                'HINT' => '',
                'HEADING' => '',
            ],
            'ORDER_CHANGE_STATUS_TO_3' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Сменить статус заказа на',
                'HINT' => '',
                'HEADING' => '',
            ],
			'ORDER_DATE_UPDATE_3' => [
                'TYPE' => 'number',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять заказы, если с даты последнего обновления заказа прошло больше (мин.)',
                'HINT' => '',
                'HEADING' => '',
            ],
			'LATEST_DATE_ENABLED_3' => [
                'TYPE' => 'hidden',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять самую позднюю дату',
                'HINT' => '',
                'HEADING' => '',
            ],
			'AGENT_CHANGE_HOUR_4' => [
                'TYPE' => 'number',
                'DEFAULT' => '18',
                'DESCRIPTION' => 'Час смены статуса',
                'HINT' => '',
                'HEADING' => 'Смена статуса 4',
            ],
			'ORDER_CHANGE_STATUS_4' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'При статусе заказа',
                'HINT' => '',
                'HEADING' => '',
            ],
            'ORDER_CHANGE_STATUS_TO_4' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Сменить статус заказа на',
                'HINT' => '',
                'HEADING' => '',
            ],
			'ORDER_DATE_UPDATE_4' => [
                'TYPE' => 'number',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять заказы, если с даты последнего обновления заказа прошло больше (мин.)',
                'HINT' => '',
                'HEADING' => '',
            ],
			'LATEST_DATE_ENABLED_4' => [
                'TYPE' => 'hidden',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять самую позднюю дату',
                'HINT' => '',
                'HEADING' => '',
            ],
			
			'AGENT_CHANGE_HOUR_5' => [
                'TYPE' => 'number',
                'DEFAULT' => '18',
                'DESCRIPTION' => 'Час смены статуса',
                'HINT' => '',
                'HEADING' => 'Смена статуса 5',
            ],
			'ORDER_CHANGE_STATUS_5' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'При статусе заказа',
                'HINT' => '',
                'HEADING' => '',
            ],
            'ORDER_CHANGE_STATUS_TO_5' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Сменить статус заказа на',
                'HINT' => '',
                'HEADING' => '',
            ],
			'ORDER_DATE_UPDATE_5' => [
                'TYPE' => 'number',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять заказы, если с даты последнего обновления заказа прошло больше (мин.)',
                'HINT' => '',
                'HEADING' => '',
            ],
			'LATEST_DATE_ENABLED_5' => [
                'TYPE' => 'checkbox',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять самую позднюю дату',
                'HINT' => '',
                'HEADING' => '',
            ],
			'AGENT_CHANGE_HOUR_6' => [
                'TYPE' => 'number',
                'DEFAULT' => '18',
                'DESCRIPTION' => 'Час смены статуса',
                'HINT' => '',
                'HEADING' => 'Смена статуса 6',
            ],
			'ORDER_CHANGE_STATUS_6' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'При статусе заказа',
                'HINT' => '',
                'HEADING' => '',
            ],
            'ORDER_CHANGE_STATUS_TO_6' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Сменить статус заказа на',
                'HINT' => '',
                'HEADING' => '',
            ],
			'ORDER_DATE_UPDATE_6' => [
                'TYPE' => 'number',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять заказы, если с даты последнего обновления заказа прошло больше (мин.)',
                'HINT' => '',
                'HEADING' => '',
            ],
			'LATEST_DATE_ENABLED_6' => [
                'TYPE' => 'checkbox',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять самую позднюю дату',
                'HINT' => '',
                'HEADING' => '',
            ],
			'AGENT_CHANGE_HOUR_7' => [
                'TYPE' => 'number',
                'DEFAULT' => '18',
                'DESCRIPTION' => 'Час смены статуса',
                'HINT' => '',
                'HEADING' => 'Смена статуса 7',
            ],
			'ORDER_CHANGE_STATUS_7' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'При статусе заказа',
                'HINT' => '',
                'HEADING' => '',
            ],
            'ORDER_CHANGE_STATUS_TO_7' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Сменить статус заказа на',
                'HINT' => '',
                'HEADING' => '',
            ],
			'ORDER_DATE_UPDATE_7' => [
                'TYPE' => 'number',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять заказы, если с даты последнего обновления заказа прошло больше (мин.)',
                'HINT' => '',
                'HEADING' => '',
            ],
			'LATEST_DATE_ENABLED_7' => [
                'TYPE' => 'checkbox',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять самую позднюю дату',
                'HINT' => '',
                'HEADING' => '',
            ],
			'AGENT_CHANGE_HOUR_8' => [
                'TYPE' => 'number',
                'DEFAULT' => '18',
                'DESCRIPTION' => 'Час смены статуса',
                'HINT' => '',
                'HEADING' => 'Смена статуса 8',
            ],
			'ORDER_CHANGE_STATUS_8' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'При статусе заказа',
                'HINT' => '',
                'HEADING' => '',
            ],
            'ORDER_CHANGE_STATUS_TO_8' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Сменить статус заказа на',
                'HINT' => '',
                'HEADING' => '',
            ],
			'ORDER_DATE_UPDATE_8' => [
                'TYPE' => 'number',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять заказы, если с даты последнего обновления заказа прошло больше (мин.)',
                'HINT' => '',
                'HEADING' => '',
            ],
			'LATEST_DATE_ENABLED_8' => [
                'TYPE' => 'checkbox',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять самую позднюю дату',
                'HINT' => '',
                'HEADING' => '',
            ],
			
            'ORDER_STOP_PAYED' => [
                'TYPE' => 'checkbox',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Не проверять оплаченные заказы',
                'HINT' => '',
                'HEADING' => 'Не проверять заказы',
            ],
            'ORDER_STOP_CANCELED' => [
                'TYPE' => 'checkbox',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Не проверять отмененные заказы',
                'HINT' => '',
                'HEADING' => '',
            ]
        ]
    ];

    $arAllOptions = [];
    foreach ($arTabs AS $arTab) {
        $optName = $arTab['DIV'];
        $arAllOptions = array_merge($arAllOptions, $arOptions[$optName]);
    }

    $request = Application::getInstance()->getContext()->getRequest();

    if ($request->isPost()) {
        if ((!empty($request->getPost('save')) || !empty($request->getPost('restore'))) && check_bitrix_sessid()) {
            if (!empty($request->getPost('restore'))) {
                Option::set($MODULE_ID, 'ORDER_CHECK_COUNT', 10);
				Option::set($MODULE_ID, 'AGENT_CHANGE_HOUR_1', 18);
				Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_1', '');
                Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_TO_1', '');
				Option::set($MODULE_ID, 'ORDER_DATE_UPDATE_1', 0);
				Option::set($MODULE_ID, 'LATEST_DATE_ENABLED_1', 'N');
				Option::set($MODULE_ID, 'AGENT_CHANGE_HOUR_2', 18);
				Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_2', '');
                Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_TO_2', '');
				Option::set($MODULE_ID, 'ORDER_DATE_UPDATE_2', 0);
				Option::set($MODULE_ID, 'LATEST_DATE_ENABLED_2', 'N');
				Option::set($MODULE_ID, 'AGENT_CHANGE_HOUR_3', 18);
				Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_3', '');
                Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_TO_3', '');
				Option::set($MODULE_ID, 'ORDER_DATE_UPDATE_3', 0);
				Option::set($MODULE_ID, 'LATEST_DATE_ENABLED_3', 'N');
				Option::set($MODULE_ID, 'AGENT_CHANGE_HOUR_4', 18);
				Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_4', '');
                Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_TO_4', '');
				Option::set($MODULE_ID, 'ORDER_DATE_UPDATE_4', 0);
				Option::set($MODULE_ID, 'LATEST_DATE_ENABLED_4', 'N');
				
				Option::set($MODULE_ID, 'AGENT_CHANGE_HOUR_5', 18);
				Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_5', '');
                Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_TO_5', '');
				Option::set($MODULE_ID, 'ORDER_DATE_UPDATE_5', 0);
				Option::set($MODULE_ID, 'LATEST_DATE_ENABLED_5', 'N');
				Option::set($MODULE_ID, 'AGENT_CHANGE_HOUR_6', 18);
				Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_6', '');
                Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_TO_6', '');
				Option::set($MODULE_ID, 'ORDER_DATE_UPDATE_6', 0);
				Option::set($MODULE_ID, 'LATEST_DATE_ENABLED_6', 'N');
				Option::set($MODULE_ID, 'AGENT_CHANGE_HOUR_7', 18);
				Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_7', '');
                Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_TO_7', '');
				Option::set($MODULE_ID, 'ORDER_DATE_UPDATE_7', 0);
				Option::set($MODULE_ID, 'LATEST_DATE_ENABLED_7', 'N');
				Option::set($MODULE_ID, 'AGENT_CHANGE_HOUR_8', 18);
				Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_8', '');
                Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_TO_8', '');
				Option::set($MODULE_ID, 'ORDER_DATE_UPDATE_8', 0);
				Option::set($MODULE_ID, 'LATEST_DATE_ENABLED_8', 'N');
				
                Option::set($MODULE_ID, 'ORDER_STOP_PAYED', 'Y');
                Option::set($MODULE_ID, 'ORDER_STOP_CANCELED', 'Y');

                CAdminMessage::ShowMessage(['MESSAGE' => 'Восстановлены значения по умолчанию', 'TYPE' => 'OK']);
            } else {
                foreach ($arAllOptions as $code => $v) {
                    if (empty($request->getPost($code))) {
                        if ($v['TYPE'] != 'link') {
                            Option::set($MODULE_ID, $code, $v['DEFAULT']);
                        }
                    } else {
                        if ($v['TYPE'] == 'checkbox' && $request->getPost($code) <> 'Y') {
                            Option::set($MODULE_ID, $code, $v['DEFAULT']);
                            continue;
                        }

                        Option::set($MODULE_ID, $code, $request->getPost($code));
                    }
                }
				
                CAdminMessage::ShowMessage(['MESSAGE' => 'Значения сохранены', 'TYPE' => 'OK']);
            }

            CAgent::RemoveModuleAgents($MODULE_ID);

            $dateStart = date('d.m.Y H:i:s', time() + (5 * 60));
            CAgent::AddAgent($MODULE_AGENT_FUNCTION, $MODULE_ID, 'Y', (5 * 60), '', 'Y', $dateStart);
        }
    }

    $tabControl->Begin();
}
?>

<form method="POST" action="<?= $APPLICATION->GetCurPage() ?>?mid=<?= urlencode($mid) ?>&lang=<?= LANGUAGE_ID ?>">
    <?php
    Extension::load('ui.hint');
    Extension::load('ui.alerts');

    foreach ($arTabs AS $arTab) {

        $optName = $arTab['DIV'];

        $tabControl->BeginNextTab();

        foreach ($arOptions[$optName] as $code => $v) {
			if (!empty($v['HEADING'])): ?>
                <tr class="heading">
                    <td colspan="2"><?= $v['HEADING'] ?></td>
                </tr>
            <? endif; ?>
			
            <tr>
                <td width="40%">
					<? if ($v['TYPE'] != 'hidden'): ?>
						<label for=""><?= $v['DESCRIPTION'] ?></label>
					<? endif; ?>
                </td>
                <td width="60%">
					<? if ($v['TYPE'] == 'checkbox'): ?>
                        <input type="checkbox" name="<?= $code ?>" id="<?= $code ?>" value="Y"
                               <? if (Option::get($MODULE_ID, $code) == "Y"): ?>checked<? endif; ?>>
                    <? elseif ($v['TYPE'] == 'select_status'): ?>
                        <select name="<?= $code ?>" id="<?= $code ?>">
                            <option value="">Выберите статус</option>
                            <? foreach ($statusOrderResult as $value): ?>
                                <option value="<?= $value['STATUS_ID'] ?>"
                                        <? if (Option::get($MODULE_ID, $code) == $value['STATUS_ID']): ?>selected<? endif; ?>><?= $value['NAME'] ?></option>
                            <? endforeach; ?>
                        </select>
                    <? elseif ($v['TYPE'] == 'number'): ?>
                        <input type="<?= $v['TYPE'] ?>" size="35" min="1" max="1000000" name="<?= $code ?>"
                               id="<?= $code ?>" value="<?= Option::get($MODULE_ID, $code) ?>">
					<? elseif ($v['TYPE'] == 'hidden'): ?>
                        <input type="<?= $v['TYPE'] ?>" type="checkbox" name="<?= $code ?>" id="<?= $code ?>" value="N">
                    <? else: ?>
                        <input type="<?= $v['TYPE'] ?>" size="35" name="<?= $code ?>" id="<?= $code ?>"
                               value="<?= Option::get($MODULE_ID, $code) ?>">
                    <? endif; ?>
                    <? if (!empty($v['HINT'])): ?>
                        <span data-hint="<?= $v['HINT'] ?>"></span>
                    <? endif; ?>
                </td>
            </tr>
            <?php
        }
    }

    ?>

    <? $tabControl->Buttons(); ?>
    <input type="submit" name="save" value="Сохранить"
           title="<?= GetMessage("MAIN_OPT_SAVE_TITLE") ?>" class="adm-btn-save">
    <input type="button" name="cancel" value="Отменить"
           title="<?= GetMessage("MAIN_OPT_CANCEL_TITLE") ?>" onclick="window.location=''">
    <input type="submit" name="restore" title="По умолчанию"
           OnClick="return confirm('Внимание! Все настройки будут перезаписаны значениями по умолчанию. Продолжить?')"
           value="По умолчанию">
    <?= bitrix_sessid_post(); ?>
    <? $tabControl->End(); ?>
</form>

<script>
    BX.ready(function () {
        BX.UI.Hint.init(BX('#AgentOptions'));
    })
</script>