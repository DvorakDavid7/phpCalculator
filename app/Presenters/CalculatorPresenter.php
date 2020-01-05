<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;
use App\Model\CalculatorManager;
use Nette\Application\UI\Form;

class CalculatorPresenter extends Presenter
{
    private $result = null;
    private $calculatorManager;

    const
        FORM_MSG_REQUIRED = 'Tohle pole je povinné.',
        FORM_MSG_RULE = 'Tohle pole má neplatný formát.';


    public function __construct(CalculatorManager $calculatorManager)
    {
        $this->calculatorManager = $calculatorManager;
    }

    
    public function renderDefault()
    {
        $this->template->result = $this->result;
    }


    protected function createComponentCalculatorForm()
    {
        $form = new Form;
        $form->addRadioList('operation', 'Operace:', $this->calculatorManager->getOperations())
             ->setDefaultValue(CalculatorManager::ADD)
             ->setRequired(self::FORM_MSG_REQUIRED);
        $form->addText('x', 'První číslo:')
            ->setType('number')
            ->setDefaultValue(0)
            ->setRequired(self::FORM_MSG_REQUIRED)
            ->addRule(Form::INTEGER, self::FORM_MSG_RULE);
        $form->addText('y', 'Druhé číslo:')
            ->setType('number')
            ->setDefaultValue(0)
            ->setRequired(self::FORM_MSG_REQUIRED)
            ->addRule(Form::INTEGER, self::FORM_MSG_RULE)
            // dělení nulou.
            ->addConditionOn($form['operation'], Form::EQUAL, CalculatorManager::DIVIDE)
            ->addRule(Form::PATTERN, 'Nelze dělit nulou.', '^[^0].*');
        $form->addSubmit('calculate', 'Spočítej výsledek');
        $form->onSuccess[] = [$this, 'calculatorFormSucceeded'];
        return $form;
    }


    public function calculatorFormSucceeded($form, $values)
    {
        $this->result = $this->calculatorManager->calculate($values->operation, $values->x, $values->y);
    }
}
