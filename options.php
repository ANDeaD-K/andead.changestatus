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
            'AGENT_CHANGE_HOUR' => [
                'TYPE' => 'number',
                'DEFAULT' => '18',
                'DESCRIPTION' => 'Час смены статуса',
                'HINT' => '',
                'HEADING' => '',
            ],
            'ORDER_CHECK_COUNT' => [
                'TYPE' => 'number',
                'DEFAULT' => '10',
                'DESCRIPTION' => 'Количество заказов для проверки за 1 раз (шт.)',
                'HINT' => '',
                'HEADING' => '',
            ],
			'ORDER_CHANGE_STATUS_1' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'При статусе заказа',
                'HINT' => '',
                'HEADING' => 'Смена статуса 1',
            ],
            'ORDER_CHANGE_STATUS_TO_1' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Сменить статус заказа на',
                'HINT' => '',
                'HEADING' => '',
            ],
			'ORDER_CHANGE_STATUS_2' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'При статусе заказа',
                'HINT' => '',
                'HEADING' => 'Смена статуса 2',
            ],
            'ORDER_CHANGE_STATUS_TO_2' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Сменить статус заказа на',
                'HINT' => '',
                'HEADING' => '',
            ],
			'ORDER_CHANGE_STATUS_3' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'При статусе заказа',
                'HINT' => '',
                'HEADING' => 'Смена статуса 3',
            ],
            'ORDER_CHANGE_STATUS_TO_3' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Сменить статус заказа на',
                'HINT' => '',
                'HEADING' => '',
            ],
			'ORDER_CHANGE_STATUS_4' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'При статусе заказа',
                'HINT' => '',
                'HEADING' => 'Смена статуса 4',
            ],
            'ORDER_CHANGE_STATUS_TO_4' => [
                'TYPE' => 'select_status',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Сменить статус заказа на',
                'HINT' => '',
                'HEADING' => '',
            ],
            'ORDER_DATE_UPDATE' => [
                'TYPE' => 'number',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Проверять заказы, если с даты последнего обновления заказа прошло больше (мин.)',
                'HINT' => '',
                'HEADING' => '',
            ],
            'ORDER_STOP_PAYED' => [
                'TYPE' => 'checkbox',
                'DEFAULT' => '',
                'DESCRIPTION' => 'Не проверять оплаченные заказы',
                'HINT' => '',
                'HEADING' => '',
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
                Option::set($MODULE_ID, 'AGENT_CHANGE_HOUR', 18);
                Option::set($MODULE_ID, 'ORDER_CHECK_COUNT', 10);
				Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_1', '');
                Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_TO_1', '');
				Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_2', '');
                Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_TO_2', '');
				Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_3', '');
                Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_TO_3', '');
				Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_4', '');
                Option::set($MODULE_ID, 'ORDER_CHANGE_STATUS_TO_4', '');
                Option::set($MODULE_ID, 'ORDER_DATE_UPDATE', '');
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
                    <label for=""><?= $v['DESCRIPTION'] ?></label>
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