<? require('headerdata.php'); ?>

<? $page_title = "Plugin Updater - Help - VOUPR"; ?>
<? include('header.php'); ?>

<h3>Plugin Updater &mdash; How It Works</h3>

<p>The VOUPR updater script checks your plugin list and installs or downloads updates automatically.
It runs on <strong>macOS</strong>, <strong>Linux</strong>, and <strong>Windows</strong> with no additional software required.</p>

<div class="infobox" style="max-width: 100%;">
<h4 class="firsth">Step 1 &mdash; Set Your Download Preferences</h4>
<p>Go to <a href="userplugins.php">My Plugins</a> and choose a script action for each plugin.
Hit <em>Save Preferences</em> when done. The script will read these settings each time it runs.</p>

<table class="pluginlist" style="width: 100%;">
	<tr class="heading">
		<td style="width: 13%;">Mode</td>
		<td style="width: 44%;">What the script does</td>
		<td>Good for</td>
	</tr>
	<tr>
		<td><strong>Ask</strong> <em>(default)</em></td>
		<td>Prompts you with [y/N] before doing anything. You decide each time the script runs.</td>
		<td>Most users &mdash; gives you full control. Note that installing will overwrite any changes you have made to the plugin files.</td>
	</tr>
	<tr>
		<td><strong>Install</strong></td>
		<td>Automatically downloads and extracts the latest version with no prompt. Also installs the plugin if it is not present locally.</td>
		<td>Plugins you use stock and never modify. Easiest option &mdash; just run the script and walk away.</td>
	</tr>
	<tr>
		<td><strong>Download Only</strong></td>
		<td>Automatically downloads the zip into your plugin folder but does not extract it. You unzip what you need manually.</td>
		<td>Plugins you have customised. Lets you compare and merge your changes before overwriting anything.</td>
	</tr>
	<tr>
		<td><strong>Skip</strong></td>
		<td>The script ignores this plugin entirely.</td>
		<td>Plugins you develop yourself or manage completely by hand.</td>
	</tr>
</table>
</div>

<br>

<div class="infobox" style="max-width: 100%;">
<h4 class="firsth">Step 2 &mdash; Generate an API Token</h4>
<p>Go to <a href="settings.php">Settings</a> and click <em>Generate API Token</em>.</p>
<ul>
	<li>Your token is shown <strong>once</strong> &mdash; copy it before leaving the page.</li>
	<li>The token is pre-filled into the script automatically when you download it (Step 3).</li>
	<li>If you lose your token, click <em>Regenerate Token</em>. The old token stops working immediately.</li>
	<li>Treat your token like a password &mdash; anyone with it can download and sync your plugin list.</li>
</ul>
</div>

<br>

<div class="infobox" style="max-width: 100%;">
<h4 class="firsth">Step 3 &mdash; Download Your Script</h4>
<p>Go to <a href="settings.php">Settings</a> and click the download link for your operating system.
The script is generated with your token and site address already filled in.</p>
<ul>
	<li><strong>macOS</strong> &mdash; saves as <code>voupr-update.sh</code></li>
	<li><strong>Linux</strong> &mdash; saves as <code>voupr-update-linux.sh</code></li>
	<li><strong>Windows</strong> &mdash; saves as <code>voupr-update.ps1</code></li>
</ul>
<p>If you regenerate your token you will need to download the script again.</p>
</div>

<br>

<div class="infobox" style="max-width: 100%;">
<h4 class="firsth">Step 4 &mdash; Configure &amp; Run</h4>

<p><strong>Plugin folder path (all platforms)</strong><br>
The script defaults to the standard Vendetta Online plugin directory for your OS.
If you have a non-standard install, either edit the path at the top of the script or set an
environment variable before running it:</p>

<table class="pluginlist" style="width: 100%;">
	<tr class="heading">
		<td style="width: 10%;">Platform</td>
		<td style="width: 45%;">Default path</td>
		<td>Override</td>
	</tr>
	<tr>
		<td>macOS</td>
		<td><code>/Applications/Vendetta.app/Contents/Resources/plugins</code></td>
		<td><code>PLUGIN_DIR="/your/path" bash voupr-update.sh</code></td>
	</tr>
	<tr>
		<td>Linux</td>
		<td><code>~/.vendetta/plugins</code></td>
		<td><code>PLUGIN_DIR="/your/path" bash voupr-update-linux.sh</code></td>
	</tr>
	<tr>
		<td>Windows</td>
		<td><code>C:\Program Files (x86)\Vendetta Online\plugins</code></td>
		<td>Set <code>$env:PLUGIN_DIR</code> before running, or edit the path at the top of the script.</td>
	</tr>
</table>

<br>

<p><strong>Windows</strong></p>
<ol>
	<li>Right-click <strong>PowerShell</strong> in the Start menu and choose <strong>Run as administrator</strong>.
		This is required so the script can write to the Program Files plugin folder.</li>
	<li>Unblock the downloaded script so Windows will run it:
		<br><code>Unblock-File -Path .\voupr-update.ps1</code>
		<br><em>This removes the internet-download flag from this file only and does not change any system security settings.</em></li>
	<li>Run the script:
		<br><code>powershell -File .\voupr-update.ps1</code></li>
</ol>

<br>

<p><strong>macOS &amp; Linux</strong></p>
<p>Open a terminal and run the script directly with bash:</p>
<p><code>bash voupr-update.sh</code></p>
<p>Or make it executable once so you can run it without typing <code>bash</code> each time:</p>
<p><code>chmod +x voupr-update.sh</code><br>
<code>./voupr-update.sh</code></p>

</div>

<? include('footer.php'); ?>
