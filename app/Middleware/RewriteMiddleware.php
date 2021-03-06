<?php

declare(strict_types=1);

namespace App\Middleware;

use App\CodeFec\Annotation\RouteRewrite;
use App\Controller\AdminController;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\HttpServer\Router\Dispatched;
use Hyperf\HttpServer\Router\Handler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RewriteMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var Dispatched $dispatched */
        $dispatched = $request->getAttribute(Dispatched::class);
	
		// 从注解内读
	    $Route_Class = AnnotationCollector::getClassesByAnnotation(RouteRewrite::class);
		foreach ($Route_Class as $key=>$data){
			$callback = [$key,$data->callback];
			$Plugin = explode('\\', $key);
			if(count($Plugin) >= 1 && $Plugin[1]==="Themes"){
				return $handler->handle($request);
			}
			if(count($Plugin)>=3){
				$Plugin = $Plugin[2];
			}else{
				return $handler->handle($request);
			}
			if(is_dir(BASE_PATH . "/app/Plugins/" . $Plugin) && !in_array($Plugin, getEnPlugins(), true)) {
				return $handler->handle($request);
			}
			if (@$dispatched->handler->route === $data->route && $data->method===request()->getMethod()) {
				$dispatched->handler->callback = $callback;
			}
		}
	
	    $routeMethods = AnnotationCollector::getMethodsByAnnotation(RouteRewrite::class);
	    foreach($routeMethods as $data){
		    $callback = [$data['class'],$data['method']];
		    $Plugin = explode('\\', $data['class']);
		    if(count($Plugin) >= 1 && $Plugin[1]==="Themes"){
			    return $handler->handle($request);
		    }
		    if(count($Plugin)>=3){
			    $Plugin = $Plugin[2];
		    }else{
			    return $handler->handle($request);
		    }
		    if(is_dir(BASE_PATH . "/app/Plugins/" . $Plugin) && !in_array($Plugin, getEnPlugins(), true)) {
			    return $handler->handle($request);
		    }
		    if (@$dispatched->handler->route === $data['annotation']->route &&  $data['annotation']->method===request()->getMethod()) {
			    $dispatched->handler->callback = $callback;
		    }
	    }
        return $handler->handle($request);

    }
}