<?php require_once('../qcubed.inc.php'); ?>
<?php require('../includes/header.inc.php'); ?>

<div id="instructions" class="full">
	<h1>Introduction to the Plugin Ecosystem</h1>

	<p>QCubed was built on a principle that the core distribution should be
		lightweight and extensible. A part of that vision is an easy-to-use
		plugin infrastructure. Our goal is to create a system where every viable
		part of the core framework can be extended with a community-driven
		plugin.</p>

	<p>If you have experience with QCodo - the predecessor of QCubed - you may
		have experience with custom <strong>QControls</strong>. Those were pretty easy to
		install and distribute - just download the file and hand-edit your class
		includes. The problems came when the author wanted to also include an
		example with the QControls - hooking those up was yet another manual
		step. Doing any sort of compatibility checks (version of the plugin
		against the version of the framework) was pretty much impossible.</p>

	<p>With QCubed, there's a firm "contract" between plugin writers and the
		core framework. That contract specifies how exactly a plugin is
		installed, and uninstalled - so that consuming those plugins is a
		breeze. And by breeze, I mean one-click setup - literally, copying all
		relevant files to the right locations, class configurations, example
		hookups, everything, is done for you.</p>

	<p>Go ahead, try it out for yourself! QCubed includes a <a
			href="../../_devtools/plugin_manager.php">Plugin Manager</a>
		component that lists out the plugins you have installed, and lets you
		install new ones. You can get the list of plugins that are currently
		available from the <a target="_blank"
							  href=" <?php echo QPluginInstaller::ONLINE_PLUGIN_REPOSITORY; ?>">online repository</a>.
		Just download a plugin .zip file, then navigate to the Plugin Manager
		and press <strong>Install a new Plugin</strong>. Then pick the file you just downloaded.
		Review the plugin details screen to confirm that this is the plugin that
		you want, and press <strong>Install</strong>! That's it, you're done - the plugin is now
		installed and configured for use. The Plugin Manager will show you links
		to the example that comes with your plugin so you can get started with it
		right away.</p>

	<p>Uninstalling plugins is just as easy - navigate to the Plugin Manager,
		pick the plugin you want to remove, click on it, then click <strong>Uninstall</strong>.
		QCubed will then delete all folders that the plugin put on your box.
		Note that if you have placed these folders are under source control, you
		need to make sure that the folders are writeable before you ask QCubed to
		uninstall the plugin.</p>
</div>

<style>#viewSource { display: none; }</style>

<?php require('../includes/footer.inc.php'); ?>