<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BEAR\Package\Module\Database\Dbal;

use Doctrine\DBAL\Connection as DbalConnection;
use Doctrine\DBAL\Driver\Connection as DriverConnection;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap3View;
use Pagerfanta\View\ViewInterface;

/**
 * Pager enabled connection
 *
 * This class is used Doctrine 'wrapperClass' option.
 *
 * @see http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#wrapper-class
 */
class ApiPagerConnection extends DbalConnection implements DriverConnection
{
    /**
     * Maximum item per page
     *
     * @var int
     */
    private $maxPerPage = 10;

    /**
     * Pager query key
     *
     * @var string
     */
    private $pageKey = '_start';

    /**
     * Current page number
     *
     * @var int
     */
    private $currentPage;

    /**
     * Options
     *
     * @var array
     */
    private $viewOptions = [
        'prev_message' => '&laquo;',
        'next_message' => '&raquo;'
    ];

    /**
     * View
     *
     * @var ViewInterface
     */
    private $view;

    /**
     * Route generator
     *
     * @var callable
     */
    private $routeGenerator;

    /**
     * Pager library - pagerfanta
     *
     * @var Pagerfanta
     */
    private $pagerfanta;

    /**
     * Set maximum item per page
     *
     * @param int $maxPerPage
     *
     * @return $this
     */
    public function setMaxPerPage($maxPerPage)
    {
        $this->maxPerPage = $maxPerPage;

        return $this;
    }

    /**
     * Set page query key (default:_page)
     *
     * @param string $pageKey
     *
     * @return $this
     */
    public function setPageKey($pageKey)
    {
        $this->pageKey = $pageKey;

        return $this;
    }

    /**
     * Set current page
     *
     * @param int $currentPage
     *
     * @return $this
     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * Set view
     *
     * @param ViewInterface $view
     *
     * @return $this
     */
    public function setView(ViewInterface $view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Set route generator
     *
     * @param callable $routeGenerator
     *
     * @return $this
     */
    public function setRouteGenerator(callable $routeGenerator)
    {
        $this->routeGenerator = $routeGenerator;

        return $this;
    }

    /**
     * Set view option
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setViewOption($key, $value)
    {
        $this->viewOptions[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function query()
    {
        $this->currentPage = $this->currentPage ? : (isset($_GET[$this->pageKey]) ? $_GET[$this->pageKey] : 1);
        $firstResult = ($this->currentPage - 1) * $this->maxPerPage;
        $args = func_get_args();
        $query = $args[0];
        $this->pagerfanta = new Pagerfanta(new PagerfantaDbalAdapter($this, $query));
        $this->pagerfanta->setMaxPerPage($this->maxPerPage)->setCurrentPage($this->currentPage, false, true);
        $pagerQuery = $this->getDatabasePlatform()->modifyLimitQuery($query, $this->maxPerPage, $firstResult);
        $args[0] = $pagerQuery;
        $result = call_user_func_array(array('Doctrine\DBAL\Connection', 'query'), $args);

        return $result;
    }

    /**
     * Return pagers
     *
     * @return array
     */
    public function getPager()
    {
        // view
        if (!$this->pagerfanta) {
            return [];
        }
        $pager = [
            'maxPerPage' => $this->maxPerPage,
            'current' => $this->currentPage,
            'total' => $this->pagerfanta->getNbResults(),
            'hasNext' => $this->pagerfanta->hasNextPage(),
            'hasPrevious' => $this->pagerfanta->hasPreviousPage(),
            'html' => $this->getHtml($this->pagerfanta)
        ];

        return $pager;
    }

    /**
     * Return html
     *
     * @return string
     */
    private function getHtml()
    {
        $view = $this->view ? : new TwitterBootstrap3View;
        $routeGenerator = $this->routeGenerator ? : function ($page) {
            return "?{$this->pageKey}={$page}";
        };
        $html = $view->render(
            $this->pagerfanta,
            $routeGenerator,
            $this->viewOptions
        );

        return $html;
    }
}
