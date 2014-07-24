<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Provide\ResourceView;

use BEAR\Resource\Code;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\LibDirInject;
use BEAR\Sunday\Extension\ResourceView\TemplateEngineRendererInterface;
use BEAR\Sunday\Extension\TemplateEngine\TemplateEngineAdapterInterface;
use Ray\Aop\WeavedInterface;
use ReflectionClass;
use Ray\Di\Di\Inject;

class TemplateEngineRenderer implements TemplateEngineRendererInterface
{
    use LibDirInject;

    /**
     * Template engine adapter
     *
     * @var TemplateEngineAdapterInterface
     */
    private $templateEngineAdapter;

    /**
     * ViewRenderer Setter
     *
     * @param TemplateEngineAdapterInterface $templateEngineAdapter
     *
     * @Inject
     * @SuppressWarnings("long")
     */
    public function __construct(TemplateEngineAdapterInterface $templateEngineAdapter)
    {
        $this->templateEngineAdapter = $templateEngineAdapter;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings("long")
     */
    public function render(ResourceObject $resourceObject)
    {
        $noContent = $resourceObject->code === Code::NO_CONTENT || ($resourceObject->code >= 300 && $resourceObject->code < 400);
        if ($noContent === true) {
            $resourceObject->view = '';
            return '';
        }
        if (is_scalar($resourceObject->body)) {
            $resourceObject->view = $resourceObject->body;

            return (string) $resourceObject->body;
        }

        // assign 'resource'
        $this->templateEngineAdapter->assign('resource', $resourceObject); 

        // assign all
        if (is_array($resourceObject->body) || $resourceObject->body instanceof \Traversable) {
            $this->templateEngineAdapter->assignAll((array) $resourceObject->body);
        }


        if (method_exists($resourceObject, 'getTemplate') && $resourceObject->getTemplate()) {
            $templatePath = $this->libDir . '/twig/template/' . $resourceObject->getTemplate() . '.';
        }

        if (!isset($templatePath)) {
            $file =  ($resourceObject instanceof WeavedInterface) ?
                (new ReflectionClass($resourceObject))->getParentClass()->getFileName() :
                    (new ReflectionClass($resourceObject))->getFileName();

            $templatePath = substr($file, 0, -3);
        }

        
        return $this->templateEngineAdapter->fetch($templatePath);
    }
}
