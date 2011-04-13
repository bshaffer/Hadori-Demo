<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->dispatcher->connect('component.method_not_found', array('sfActionExtra', 'observeMethodNotFound'));

    sfYaml::setSpecVersion('1.1');
    // for compatibility / remove and enable only the plugins you want
    $this->enablePlugins(array(
      'sfDoctrinePlugin',
      'sfDoctrineGuardPlugin',
      'sfFormExtraPlugin',
      'sfGoogleAnalyticsPlugin',
      'sfTaskExtraPlugin',
      'csDoctrineActAsSortablePlugin',
      'sfThemeGeneratorPlugin',
      'sfHadoriThemePlugin',
    ));
  }

  public function configureDoctrine(Doctrine_Manager $manager)
  {
    $manager->setAttribute(Doctrine_Core::ATTR_COLLECTION_CLASS, 'Doctrine_Collection_Extra');
  }
}
