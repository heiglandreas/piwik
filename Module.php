<?php
/**
 * Copyright (c)2014-2014 heiglandreas
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIBILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category 
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright ©2014-2014 Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     28.06.14
 * @link      https://github.com/heiglandreas/
 */

namespace OrgHeiglPiwik;


use Zend\EventManager\StaticEventManager;
use Zend\View\ViewEvent;
use Zend\View\View;

class Module
{
    protected $template = <<<EOT
var pkBaseURL = (("https:" == document.location.protocol) ? "https://%%server%%" : "http://%%server%%");
    document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
    </script><script type="text/javascript">
    try {
        var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", %%site_id%%);
        piwikTracker.trackPageView();
        piwikTracker.enableLinkTracking();
    } catch( err ) {}
EOT;

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function init()
    {
        // Attach Event to EventManager
        $events = StaticEventManager::getInstance ();

        // Add event of authentication before dispatch
        $events->attach('Zend\View\View', 'renderer', array(
            $this,
            'addPiwikCode'
        ), 110 );
    }

    /**
     * Include the PIWIK-Tracking-code into every page.
     *
     * @param $event
     */
    public function addPiwikCode(ViewEvent $event)
    {
        $model = $event->getModel();
        if (! $model instanceof \Zend\View\Model\ViewModel) {
            return;
        }

        $target         = $event->getTarget ();
        $serviceLocator = $target->getServiceLocator();
        $config         = $serviceLocator->get('config');
        $piwikConfig    = $config['orgHeiglPiwik'];

        $code = str_replace(array_map(function($e){
            return '%%' . $e . '%%';
        }, array_keys($piwikConfig)), array_values($piwikConfig), $this->template);

        $model->headScript()->appendScript('//<![CDATA[' . "\n" . $code . "\n" . '//]]>');
    }
} 