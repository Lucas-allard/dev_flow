<?php

namespace App\Services;

use App\Data\ChallengeFilterData;
use App\Data\FilterDataInterface;
use App\Repository\FilterableRepositoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

class SearchFormHandler
{
    /**
     * @var FormFactoryInterface
     */
    private FormFactoryInterface $formFactory;

    private ?FormInterface $form = null;

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param $formType
     * @param null $data
     * @param array $options
     * @return FormInterface
     */
    public function createForm($formType, $data = null, array $options = [])
    {
        $this->form = $this->formFactory->create($formType, $data, $options);
        return $this->form;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function handleForm(Request $request): bool
    {
        $this->form->handleRequest($request);
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            return true;
        }
        return false;
    }

    public function getSearchForm(): FormView
    {
        return $this->form->createView();
    }

}
