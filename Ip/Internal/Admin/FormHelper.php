<?php


namespace Ip\Internal\Admin;


class FormHelper
{


    public static  function getLanguageSelectForm()
    {
        //create form object
        $form = new \Ip\Form();
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_ADMIN);

        $form->addClass('ipsLanguageSelect');

        //add text field to form object
        $field = new \Ip\Form\Field\Select(
            array(
                'name' => 'languageCode',
                'values' => self::getAvaliableLocales()
            ));
        $field->setValue(ipConfig()->adminLocale());
        $form->addfield($field);

        return $form;
    }

    protected static function getAvaliableLocales()
    {
        $locales = array();
        $files = scandir(ipFile('Ip/Internal/Translations/translations'));

        foreach ($files as $file) {
            if (preg_match('/^Ip-admin-([a-z\_A-Z]+)\.json$/', $file, $matches)) {
                $locales[] = array($matches[1],  strtoupper($matches[1]));
            }
        }
        if (empty($locales)) {
            $locales = array(array('en', 'EN'));
        }
        return $locales;
    }

    public static  function getLoginForm()
    {
        //create form object
        $form = new \Ip\Form();
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_ADMIN);

        //add text field to form object
        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa',
                'value' => 'Admin.loginAjax', //html "name" attribute
            ));
        $form->addfield($field);


        //add text field to form object
        $field = new \Ip\Form\Field\Blank(
            array(
                'name' => 'global_error',
            ));
        $form->addfield($field);

        //add text field to form object
        $field = new \Ip\Form\Field\Text(
            array(
                'name' => 'login', //html "name" attribute
                'label' => __('Username', 'Ip-admin')
            ));
        $field->addValidator('Required');
        $form->addField($field);

        //add text field to form object
        $field = new \Ip\Form\Field\Password(
            array(
                'name' => 'password', //html "name" attribute
                'label' => __('Password', 'Ip-admin')
            ));
        $field->addValidator('Required');
        $form->addField($field);


        //add text field to form object
        $field = new \Ip\Form\Field\Submit(
            array(
                'value' => __('Login', 'Ip-admin')
            ));
        $field->addClass('ipsLoginButton');
        $form->addField($field);

        return $form;
    }

    public static function getPasswordResetForm1()
    {
        //create form object
        $form = new \Ip\Form();
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_ADMIN);

        //add text field to form object
        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa',
                'value' => 'Admin.passwordResetAjax', //html "name" attribute
            ));
        $form->addfield($field);


        //add text field to form object
        $field = new \Ip\Form\Field\Blank(
            array(
                'name' => 'global_error',
            ));
        $form->addfield($field);

        //add text field to form object
        $field = new \Ip\Form\Field\Text(
            array(
                'name' => 'username', //html "name" attribute
                'label' => __('Username or email', 'Ip-admin')
            ));
        $field->addValidator('Required');
        $form->addField($field);

        //add text field to form object
        $field = new \Ip\Form\Field\Submit(
            array(
                'value' => __('Reset', 'Ip-admin')
            ));
        $field->addClass('ipsLoginButton');
        $form->addField($field);


        return $form;
    }


    public static function getPasswordResetForm2()
    {
        //create form object
        $form = new \Ip\Form();

        //add text field to form object
        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa',
                'value' => 'Admin.passwordResetAjax2', //html "name" attribute
            ));
        $form->addfield($field);

        //add text field to form object
        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'secret',
                'value' => ipRequest()->getQuery('secret', ''), //html "name" attribute
            ));
        $form->addfield($field);

        //add text field to form object
        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'userId',
                'value' => ipRequest()->getQuery('id', ''), //html "name" attribute
            ));
        $form->addfield($field);


        //add text field to form object
        $field = new \Ip\Form\Field\Blank(
            array(
                'name' => 'global_error',
            ));
        $form->addfield($field);

        //add text field to form object
        $field = new \Ip\Form\Field\Password(
            array(
                'name' => 'password', //html "name" attribute
                'label' => __('New password', 'Ip-admin')
            ));
        $field->addValidator('Required');
        $form->addField($field);

        //add text field to form object
        $field = new \Ip\Form\Field\Submit(
            array(
                'value' => __('Save', 'Ip-admin')
            ));
        $field->addClass('ipsLoginButton');
        $form->addField($field);

        $form->addClass('ipsPasswordResetForm2');


        return $form;
    }

}
