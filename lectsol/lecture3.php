<!DOCTYPE html>
<html>

<head>

<title>'Lecture 3 | Missing Semester Solutions'</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../styles/lecture.css">
</head>

<body class=lecture>

	<h3><a href="https://missing.csail.mit.edu/2020/editors/" target="_blank">Lecture 3</a></h3>
	<ol class=lectlist>

		<li>Complete <code>vimtutor</code>. Note: it looks best in a <a href="https://en.wikipedia.org/wiki/VT100" target=_blank>80x24</a> (80 columns by 24 lines) terminal window.</li>

		<li>Download our <a href='files/vimrc'>basic vimrc</a> and save it to <code>~/.vimrc</code>. Read through the well-commented file (using Vim!), and observe how Vim looks and behaves slightly differently with the new config.</li>

		<li><p>Install and configure a plugin: <a href='https://github.com/ctrlpvim/ctrlp.vim' target=_blank>ctrlp.vim</a>.</p>
			<ol style='padding-left:20px;'>
				<li>Create the plugins directory with <code>mkdir -p ~/.vim/pack/vendor/start</code></li>
				<li>Download the plugin: <code>cd ~/.vim/pack/vendor/start; git clone https://github.com/ctrlpvim/ctrlp.vim</code></li>
				<li>Read the <a href='https://github.com/ctrlpvim/ctrlp.vim/blob/master/readme.md' target=_blank>documentation</a> for the plugin. Try using CtrlP to locate a file by navigating to a project directory, opening Vim, and using the Vim command-line to start <code>:CtrlP.</code></li>
				<li>Customize CtrlP by adding <a href='https://github.com/ctrlpvim/ctrlp.vim/blob/master/readme.md#basic-options' target=_blank>configuration</a> to your <code>~/.vimrc</code> to open CtrlP by pressing Ctrl-P.</li>

			</ol>
		</li>

		<li>To practice using Vim, re-do the <a href='https://missing.csail.mit.edu/2020/editors/#demo' target=_blank>Demo</a> from lecture on your own machine.
		<p class=inst>You can follow the video for the solution</p></li>

		<li>Use Vim for all your text editing for the next month. Whenever something seems inefficient, or when you think “there must be a better way”, try Googling it, there probably is. If you get stuck, come to office hours or send us an email.
			<p class=inst>If you know HTML, you can practice using vim by cleaning up the <a target=_blank href='https://github.com/simon-bouchard/simon-bouchard.github.io'>files</a> of this very website!</p></li>

		<li>Configure your other tools to use Vim bindings (see instructions above).</li>
		<li>Further customize your <code>~/.vimrc</code> and install more plugins.</li>
		<li>(Advanced) Convert XML to JSON (<a href='https://missing.csail.mit.edu/2020/files/example-data.xml' target=_blank>example file</a>) using Vim macros. Try to do this on your own, but you can look at the <a href='https://missing.csail.mit.edu/2020/editors/#macros' target=_blank>macros</a> section above if you get stuck.
			<div class=instblock><p>In real life you should just ask ChatGPT to do that for you but if you still want to do it with vim here is how:</p>
				<ol>
					<li>Download the file and open it in vim.
						<div class=code-container><code class=in>curl -O https://missing.csail.mit.edu/2020/files/example-data.xml</code>
							<button class="copy">Copy</button></div></li>
					<li>Delete first and last tag.
						<div class=code-container><code class=in>Gdd  ggdd</code>
							<button class="copy">Copy</button></div></li>
					<li>Insert the first <code>[</code> at the beginning of the file, the move to the very start of the second line (where the <code>&lt;person&gt;</code> tag is) and start recording the macro in a.
						<div class=code-container><code class=in>qa</code>
							<button class="copy">copy</button></div></li>
					<li>Format the first person tag:
						<div class=code-container><code class=in>^cf&gt;{ESC</code>
							<button class="copy">copy</button></div></li>
					<li>Move to the first item and change it:
						<div class=code-container><code class=in>j0^r"f&gt;s": "ESCf&lt;cf&gt;",ESC</code>
							<button class="copy">copy</button></div></li>
					<li>Move to the second item and change it:
						<div class=code-container><code class=in>j0^r"f&gt;s": "ESCf&lt;cf&gt;"ESC</code>
							<button class="copy">copy</button></div></li>
					<li>Move to the second person tag, change it and move to the next line:
						<div class=code-container><code class=in>j0^cf&gt;},ESCj0</code>
							<button class="copy">copy</button></div></li>
					<li>Close the macro with q and execute it until the end of the file (you should test it with <code>@a</code> before):
						<div class=code-container><code class=in>999@a</code>
							<button class="copy">copy</button></div></li>
					<li>You can then remove the last comma and add the final closing brakcet (<code>]</code>).</li>

				</ol>

			</div>

		</li>

	</ol>

<?php include '../partials/lectNav.php'; ?>

<script src='../js/lectureNav.js'></script>
		
<script src='../js/copyButton.js'></script>


</body>
</html>
