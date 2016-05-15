<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Tota11yPS extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'tota11yps';
        $this->tab = 'others';
        $this->version = '0.1.1';
        $this->author = 'David Gasperoni';
        $this->need_instance = 0;
        $this->embedded_version = 'v0.1.4';

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Tota11y by Khan Academy');
        $this->description = $this->l('An accessibility visualization toolkit from your friends at Khan Academy.');
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('TOTA11Y_ENABLE', true);
        Configuration::updateValue('TOTA11Y_OUTSOURCE', false);

        return parent::install() &&
            $this->registerHook('header');
    }

    public function uninstall()
    {
        Configuration::deleteByName('TOTA11Y_ENABLE');
        Configuration::deleteByName('TOTA11Y_OUTSOURCE');

        return parent::uninstall();
    }

    public function getContent()
    {
        $output = '';

        if (((bool) Tools::isSubmit('submitTota11yModule')) == true) {
            $output .= $this->postProcess();
        }

        $this->context->smarty->assign(array(
            'module_dir' => $this->_path,
            'module_name' => $this->displayName,
            'module_description' => $this->description,
        ));

        $output .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitTota11yModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable'),
                        'name' => 'TOTA11Y_ENABLE',
                        'is_bool' => true,
                        'desc' => $this->l('Use this module in the front office'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Link to tota11y/master on GitHub'),
                        'name' => 'TOTA11Y_OUTSOURCE',
                        'is_bool' => true,
                        'desc' => sprintf($this->l('Link directly to latest version on GitHub instead of embedded tota11y.js (current embedded version: %s)'), $this->embedded_version),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    protected function getConfigFormValues()
    {
        return array(
            'TOTA11Y_ENABLE' => Configuration::get('TOTA11Y_ENABLE'),
            'TOTA11Y_OUTSOURCE' => Configuration::get('TOTA11Y_OUTSOURCE'),
        );
    }

    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }

        return $this->displayConfirmation($this->l('Settings updated.'));
    }

    public function hookHeader()
    {
        if (Configuration::get('TOTA11Y_ENABLE')) {
            if (Configuration::get('TOTA11Y_OUTSOURCE')) {
                $this->context->controller->addJS('https://rawgit.com/Khan/tota11y/master/build/tota11y.min.js');
            } else {
                $this->context->controller->addJS($this->_path.'/views/js/tota11y.min.js');
            }
        }
    }
}
