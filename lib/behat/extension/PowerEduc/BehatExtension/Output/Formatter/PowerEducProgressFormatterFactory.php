<?php
// This file is part of PowerEduc - http://powereduc.org/
//
// PowerEduc is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// PowerEduc is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with PowerEduc.  If not, see <http://www.gnu.org/licenses/>.

namespace PowerEduc\BehatExtension\Output\Formatter;

use Behat\Testwork\Exception\ServiceContainer\ExceptionExtension;
use Behat\Testwork\Output\ServiceContainer\Formatter\FormatterFactory;
use Behat\Testwork\Output\ServiceContainer\OutputExtension;
use Behat\Testwork\ServiceContainer\ServiceProcessor;
use Behat\Testwork\Translator\ServiceContainer\TranslatorExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

// phpcs:disable powereduc.NamingConventions.ValidFunctionName.LowercaseMethod

/**
 * PowerEduc behat context class resolver.
 *
 * @package    core
 * @copyright  2016 Rajesh Taneja <rajesh@powereduc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class PowerEducProgressFormatterFactory implements FormatterFactory {
    /** @var ServiceProcessor */
    private $processor;

    /** @var string powereduc progress ID */
    const ROOT_LISTENER_ID_POWEREDUC = 'output.node.listener.powereducprogress';

    /** @var string powereduc printer ID */
    const RESULT_TO_STRING_CONVERTER_ID_POWEREDUC = 'output.node.printer.result_to_string';

    /** @var string Available extension points */
    const ROOT_LISTENER_WRAPPER_TAG_POWEREDUC = 'output.node.listener.powereducprogress.wrapper';

    /**
     * Initializes extension.
     *
     * @param null|ServiceProcessor $processor
     */
    public function __construct(ServiceProcessor $processor = null) {
        $this->processor = $processor ? : new ServiceProcessor();
    }

    /**
     * Builds formatter configuration.
     *
     * @param ContainerBuilder $container
     */
    public function buildFormatter(ContainerBuilder $container) {
        $this->loadRootNodeListener($container);
        $this->loadCorePrinters($container);
        $this->loadPrinterHelpers($container);
        $this->loadFormatter($container);
    }

    /**
     * Processes formatter configuration.
     *
     * @param ContainerBuilder $container
     */
    public function processFormatter(ContainerBuilder $container) {
        $this->processListenerWrappers($container);
    }

    /**
     * Loads progress formatter node event listener.
     *
     * @param ContainerBuilder $container
     */
    protected function loadRootNodeListener(ContainerBuilder $container) {
        $definition = new Definition('Behat\Behat\Output\Node\EventListener\AST\StepListener', [
            new Reference('output.node.printer.powereducprogress.step')
        ]);
        $container->setDefinition(self::ROOT_LISTENER_ID_POWEREDUC, $definition);
    }

    /**
     * Loads formatter itself.
     *
     * @param ContainerBuilder $container
     */
    protected function loadFormatter(ContainerBuilder $container) {

        $definition = new Definition('Behat\Behat\Output\Statistics\TotalStatistics');
        $container->setDefinition('output.powereducprogress.statistics', $definition);

        $powereducconfig = $container->getParameter('behat.powereduc.parameters');

        $definition = new Definition(
            'PowerEduc\BehatExtension\Output\Printer\PowerEducProgressPrinter',
            [$powereducconfig['powereducdirroot']]
        );
        $container->setDefinition('powereduc.output.node.printer.powereducprogress.printer', $definition);

        $definition = new Definition('Behat\Testwork\Output\NodeEventListeningFormatter', [
            'powereduc_progress',
            'Prints information about then run followed by one character per step.',
            [
                'timer' => true
            ],
            $this->createOutputPrinterDefinition(),
            new Definition('Behat\Testwork\Output\Node\EventListener\ChainEventListener', [
                [
                    new Reference(self::ROOT_LISTENER_ID_POWEREDUC),
                    new Definition('Behat\Behat\Output\Node\EventListener\Statistics\StatisticsListener', [
                        new Reference('output.powereducprogress.statistics'),
                        new Reference('output.node.printer.powereducprogress.statistics')
                    ]),
                    new Definition('Behat\Behat\Output\Node\EventListener\Statistics\ScenarioStatsListener', [
                        new Reference('output.powereducprogress.statistics')
                    ]),
                    new Definition('Behat\Behat\Output\Node\EventListener\Statistics\StepStatsListener', [
                        new Reference('output.powereducprogress.statistics'),
                        new Reference(ExceptionExtension::PRESENTER_ID)
                    ]),
                    new Definition('Behat\Behat\Output\Node\EventListener\Statistics\HookStatsListener', [
                        new Reference('output.powereducprogress.statistics'),
                        new Reference(ExceptionExtension::PRESENTER_ID)
                    ]),
                    new Definition('Behat\Behat\Output\Node\EventListener\AST\SuiteListener', [
                        new Reference('powereduc.output.node.printer.powereducprogress.printer')
                    ])
                ]
            ])
        ]);
        $definition->addTag(OutputExtension::FORMATTER_TAG, ['priority' => 1]);
        $container->setDefinition(OutputExtension::FORMATTER_TAG . '.powereducprogress', $definition);
    }

    /**
     * Loads printer helpers.
     *
     * @param ContainerBuilder $container
     */
    protected function loadPrinterHelpers(ContainerBuilder $container) {
        $definition = new Definition('Behat\Behat\Output\Node\Printer\Helper\ResultToStringConverter');
        $container->setDefinition(self::RESULT_TO_STRING_CONVERTER_ID_POWEREDUC, $definition);
    }

    /**
     * Loads feature, scenario and step printers.
     *
     * @param ContainerBuilder $container
     */
    protected function loadCorePrinters(ContainerBuilder $container) {
        $definition = new Definition('Behat\Behat\Output\Node\Printer\CounterPrinter', [
            new Reference(self::RESULT_TO_STRING_CONVERTER_ID_POWEREDUC),
            new Reference(TranslatorExtension::TRANSLATOR_ID),
        ]);
        $container->setDefinition('output.node.powereduc.printer.counter', $definition);

        $definition = new Definition('Behat\Behat\Output\Node\Printer\ListPrinter', [
            new Reference(self::RESULT_TO_STRING_CONVERTER_ID_POWEREDUC),
            new Reference(ExceptionExtension::PRESENTER_ID),
            new Reference(TranslatorExtension::TRANSLATOR_ID),
            '%paths.base%'
        ]);
        $container->setDefinition('output.node.powereduc.printer.list', $definition);

        $definition = new Definition('Behat\Behat\Output\Node\Printer\Progress\ProgressStepPrinter', [
            new Reference(self::RESULT_TO_STRING_CONVERTER_ID_POWEREDUC)
        ]);
        $container->setDefinition('output.node.printer.powereducprogress.step', $definition);

        $definition = new Definition('Behat\Behat\Output\Node\Printer\Progress\ProgressStatisticsPrinter', [
            new Reference('output.node.powereduc.printer.counter'),
            new Reference('output.node.powereduc.printer.list')
        ]);
        $container->setDefinition('output.node.printer.powereducprogress.statistics', $definition);
    }

    /**
     * Creates output printer definition.
     *
     * @return Definition
     */
    protected function createOutputPrinterDefinition() {
        return new Definition('Behat\Testwork\Output\Printer\StreamOutputPrinter', [
            new Definition('Behat\Behat\Output\Printer\ConsoleOutputFactory'),
        ]);
    }

    /**
     * Processes all registered pretty formatter node listener wrappers.
     *
     * @param ContainerBuilder $container
     */
    protected function processListenerWrappers(ContainerBuilder $container) {
        $this->processor->processWrapperServices(
            $container,
            self::ROOT_LISTENER_ID_POWEREDUC,
            self::ROOT_LISTENER_WRAPPER_TAG_POWEREDUC
        );
    }
}
