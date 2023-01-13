<?php

namespace App\Services;

use App\Data\FilterData;
use App\Repository\FilterableRepositoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class SearchFormHandler
{
    private $searchForm;

    /**
     * @param FormFactoryInterface $formFactory
     * @param FilterableRepositoryInterface $repository
     * @param string $formType
     * @param FilterData $filterData
     */
    public function __construct(
        private FormFactoryInterface          $formFactory,
        private FilterableRepositoryInterface $repository,
        string                                $formType,
        private FilterData                            $filterData,
    )
    {
        $this->searchForm = $this->formFactory->create($formType, $this->filterData);
    }

    /**
     * @param Request $request
     * @return array|null
     */
    public function handleSearchForm(Request $request): ?array
    {
        $this->searchForm->handleRequest($request);

        if ($this->searchForm->isSubmitted() && $this->searchForm->isValid()) {

            return $this->repository->findBySearch($this->filterData);
        }

        return null;
    }

    /**
     * @return FormInterface
     */
    public function getSearchForm(): FormInterface
    {
        return $this->searchForm;
    }
}