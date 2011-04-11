<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Launches all tests matching the appropriate parameters.  
 * See "detailed description" for further instructions.
 *
 * @package    symfony
 * @subpackage task
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfTestAllTask.class.php 29415 2010-05-12 06:24:54Z fabien $
 */
class sfTestFilesTask extends sfTestBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('files', null, sfCommandArgument::OPTIONAL, null, 'search for only these file names'),
      new sfCommandArgument('type', null, sfCommandArgument::OPTIONAL, null, 'test type: unit or functional'),
      new sfCommandArgument('application', null, sfCommandArgument::OPTIONAL, null, 'For functional tests: application to test'),
    ));
    $this->addOptions(array(
      new sfCommandOption('only-failed', 'f', sfCommandOption::PARAMETER_NONE, 'Only run tests that failed last time'),
      new sfCommandOption('xml', null, sfCommandOption::PARAMETER_REQUIRED, 'The file name for the JUnit compatible XML log file'),
      new sfCommandOption('verbose', 'v', sfCommandOption::PARAMETER_NONE, 'show test output'),
    ));

    $this->aliases = array('test');
    $this->namespace = 'test';
    $this->name = 'file';
    $this->briefDescription = 'Launches all tests';

    $this->detailedDescription = <<<EOF
The [test:file|INFO] task launches all unit and functional tests:

  [./symfony test:file|INFO]

The task launches all tests found in [test/|COMMENT].

The [files|COMMENT] argument can be used to run all tests in a directory.  Example:

  [./symfony test:file export|INFO]
  functional/backend/export/UserExportTest.............................[ok|COMMENT]
  functional/backend/export/OrganizationExportTest.....................[ok|COMMENT]

Use an [asterisk|COMMENT] to test files containing a string.  Example:
 
  [./symfony test:file user*|INFO]
  functional/backend/NewUserTest.......................................[ok|COMMENT]
  functional/frontend/UserLoginTest....................................[ok|COMMENT]
  unit/sfGuardUserTest.................................................[ok|COMMENT]

The [type|COMMENT] and [application|COMMENT] arguments can be used to pinpoint the tests to run.  Example:

  [./symfony test:file user* functional frontend|INFO]
  functional/frontend/UserLoginTest....................................[ok|COMMENT]

Note in the above example, the previously run tests in functional/backend/ and unit/ were not run   

If some tests fail, you can use the [--trace|COMMENT] option to have more
information about the failures:

  [./symfony test:file -t|INFO]

Or you can also try to fix the problem by launching them by hand or with the
[test:unit|COMMENT] and [test:functional|COMMENT] task.

Use the [--only-failed|COMMENT] option to force the task to only execute tests
that failed during the previous run:

  [./symfony test:file --only-failed|INFO]

Here is how it works: the first time, all tests are run as usual. But for
subsequent test runs, only tests that failed last time are executed. As you
fix your code, some tests will pass, and will be removed from subsequent runs.
When all tests pass again, the full test suite is run... you can then rinse
and repeat.

The task can output a JUnit compatible XML log file with the [--xml|COMMENT]
options:

  [./symfony test:file --xml=log.xml|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $baseDir = sfConfig::get('sf_test_dir');
    $finder = sfFinder::type('file')->follow_link()->name('*Test.php');
    
    $files = array();
    
    if ($arguments['files']) 
    {
      $files = $this->filterWildcardFiles(array(), $arguments['files'], $arguments);
    }
    else
    {
      $files = $finder->in($baseDir);
    }

    $files = $this->filterTestFiles($files, $arguments, $options);

    if ($options['verbose'] || count($files) == 1) 
    {
      $taskVars = array_merge(array_keys(get_defined_vars()), array('taskVars', 'testVars', 'file'));

      foreach ($files as $file)
      {
        $this->logSection('test', $file);
        
        include($file);
        
        // Free variables from tests.  They are no longer needed
        $testVars = array_diff(array_keys(get_defined_vars()), $taskVars);
        foreach ($testVars as $varName) 
        {
          unset($$varName);
        }
      }
    }
    else
    {
      require_once sfConfig::get('sf_symfony_lib_dir').'/task/test/sfLimeHarness.class.php';

      $h = new sfLimeHarness(array(
        'force_colors' => isset($options['color']) && $options['color'],
        'verbose'      => isset($options['trace']) && $options['trace'],
      ));
      $h->addPlugins(array_map(array($this->configuration, 'getPluginConfiguration'), $this->configuration->getPlugins()));
      $h->base_dir = $baseDir;

      $status = false;
      $statusFile = sfConfig::get('sf_cache_dir').'/.test_all_status';
      if ($options['only-failed'])
      {
        if (file_exists($statusFile))
        {
          $status = unserialize(file_get_contents($statusFile));
        }
      }

      if ($status)
      {
        foreach ($status as $file)
        {
          $h->register($file);
        }
      }
      else
      {
        // filter and register all tests
        $h->register($files);
      }

      $ret = $h->run() ? 0 : 1;

      file_put_contents($statusFile, serialize($h->get_failed_files()));

      if ($options['xml'])
      {
        file_put_contents($options['xml'], $h->to_xml());
      }

      return $ret; 
    }
  }
  
  public function filterWildcardFiles($files, $name, $arguments)
  { 
    // Remove ending "TEST" if user put it at the end (usually from copy-paste)
    if (strrpos($name, 'Test') == strlen($name) - 4) 
    {
      $name = substr($name, 0, strlen($name) - 4);
    }
    
    $finder = sfFinder::type('file')->follow_link()->name($name.'Test.php');
    $directories = sfFinder::type('dir')->follow_link()->name($name);
    
    $path = sfConfig::get('sf_test_dir');
    
    if ($arguments['type'] == 'unit') 
    {
      $path = $path . '/unit';
    }
    elseif ($arguments['type'] == 'functional') 
    {
      $path = $path . '/functional';
      
      if ($arguments['application']) 
      {
        $path = $path . '/' . $arguments['application'];
      }
    }
    
    $files = array_merge($files, $finder->in($path));
    
    $dirs = $directories->in($path);

    foreach ($dirs as $dir) 
    {
      $addlTests = sfFinder::type('file')->follow_link()->name('*Test.php')->in($dir);
      $files = array_merge($files, $addlTests);
    }

    return array_unique($files);
  }
}
