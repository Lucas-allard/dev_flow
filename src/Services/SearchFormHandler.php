<?php

namespace App\Services;

use App\Data\ChallengeFilterData;
use App\Data\FilterDataInterface;
use App\Repository\FilterableRepositoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class SearchFormHandler
{
    private FormFactoryInterface $formFactory;
    private string $formType;

    private FilterableRepositoryInterface $repository;
    private FilterDataInterface $filterData;

    private FormInterface $form;

    /**
     * @param FormFactoryInterface $formFactory
     * @param string $formType
     * @param FilterableRepositoryInterface $repository
     * @param FilterDataInterface $filterData
     */
    public function __construct(
        FormFactoryInterface          $formFactory,
        string                        $formType,
        FilterableRepositoryInterface $repository,
        FilterDataInterface           $filterData
    )
    {
        $this->formFactory = $formFactory;
        $this->formType = $formType;
        $this->repository = $repository;
        $this->filterData = $filterData;
    }


    /**
     * @param Request $request
     * @return FormInterface
     */
    public function createForm(Request $request): FormInterface
    {
        $form = $this->formFactory->create($this->formType, $this->filterData);

        $form->handleRequest($request);

        return $form;
    }

    /**
     * @param Request $request
     * @return null
     */
    public function handleForm(Request $request)
    {
        $this->form = $this->createForm($request);


        if ($this->form->isSubmitted() && $this->form->isValid()) {
            return $this->repository->findBySearch($this->filterData);
        }

        return null;
    }

    /**
     * @return FormInterface
     */
    public function getSearchForm(): FormInterface
    {
        return $this->form;
    }

    /**
     * @param ChallengeFilterData $filterData
     * @return SearchFormHandler
     */
    public function setFilterData(ChallengeFilterData $filterData): SearchFormHandler
    {
        $this->filterData = $filterData;
        return $this;
    }
}
