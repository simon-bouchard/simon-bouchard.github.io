<!DOCTYPE html>
<html>

<head>

<title>'Lecture 1 | Missing Semester Solutions'</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../styles/lecture.css">
</head>

<body class=lecture>

	<h3><a href="https://missing.csail.mit.edu/2020/course-shell/" target="_blank">Lecture 1</a></h3>
	<ol class=lectlist>
		<li><p>For this course, you need to be using a Unix shell like Bash or ZSH. If you are on Linux or macOS, you don’t have to do anything special. If you are on Windows, you need to make sure you are not running cmd.exe or PowerShell; you can use <a href="https://learn.microsoft.com/en-us/windows/wsl/" target="_blank">Windows Subsystem for Linux</a> or a Linux virtual machine to use Unix-style command-line tools.</p>

			<div class=inst>If you are using Windows you can download wsl directly from powershell using:
				<div class="code-container"><code class=in>wsl --install</code>
						<button class="copy">copy</button>
</div>
<p><i> Note: this is the only time you will be using powershell</i></p></div></div>

			<p>To make sure you’re running an appropriate shell, you can try the command <span><code>echo $SHELL</code></span>. If it says something like <span><samp>/bin/bash</samp></span> or <span><samp>/usr/bin/zsh</samp></span>, that means you’re running the right program. </p>
			<div class=instblock>
			<p>I recommend using zsh as your default shell. You can install it with the following commands:</p>
				<ol>	<li>To update your package repository:
					<div class=code-container><div class="in"><code>sudo apt update</code></div>
					<button class="copy">Copy</button</button></li>
					<p><i>Note: package update won't be mentionned from now on</i></p>
					<li>To install zsh:
						<div class=code-container><div class="in"><code>sudo apt install zsh -y</code></div>
						<button class="copy">Copy</button></div>
				<p><i>Note: -y flag so you don't have to type y to accept install.</i></p></li>
					<li>To verify install:
						<div class=code-container><div class="in"><code>zsh --version</code></div>
							<button class="copy">Copy</button></div>
				<p><i>Note: installation verification won't be mentioned from now on.</i></p></li>			

					<li>To define zsh as your default shell:
						<div class=code-container><code class=in>chsh -s $(which zsh)</code>
							<button class=copy>Copy</button></div>

					<li>To verify it worked:
						<div class=code-container><code class=in>echo $SHELL</code>
							<button class=copy>Copy</button></div></li>
			</ol>
					</div></li>

		<li><p>Create a new directory called missing under <span><code>/tmp</code></span></p>
			<div class="inst"><div class=code-container><div class="in"><code>mkdir /tmp/missing</code></div>
					<button class="copy">Copy</button></div></div>

			<li>	<p>Look up the <code>touch</code> program. The <code>man</code> program is your friend.</p>
				<div class="inst"><div class=code-container><div class="in"><code>man touch</code></div>
						<button class=copy>Copy</button></div></div>
				
			<li>	<p>Use touch to create a new file called <code>semester</code> in <code>missing</code>.</p>
				<div class=inst><div class=code-container><div class="in"><code>touch /tmp/missing/semester</code></div>
						<button class="copy">Copy</button></div></div></li>	

			<li>	<p>Write the following into that file, one line at a time:</p>
				<p class="instcode">#!/bin/sh<br>
				curl --head --silent https://missing.csail.mit.edu</p>
				<p>The first line might be tricky to get working. It’s helpful to know that <code>#</code> starts a comment in Bash, and <code>!</code> has a special meaning even within double-quoted (<code>"</code>) strings. Bash treats single-quoted strings (<code>'</code>) differently: they will do the trick in this case. See the Bash <a href="https://www.gnu.org/software/bash/manual/html_node/Quoting.html" target="_blank">quoting</a> manual page for more information.</p>
				<div class="instblock">
					<ol>
						<li><div class=code-container>
								<code class=in>echo '#!/bin/sh' &gt; semester</code>
								<button class="copy">Copy</button></div></li>
						<li><div class=code-container>
							<code class=in>echo 'curl --head --silent https://missing.csail.mit.edu' &gt;&gt; semester</code>
							<button class="copy">Copy</button></div>
							<p class=pinst>Make sure you are in the correct directory. Otherwise, naviguate to the correct directory with <code>cd /tmp/missing/semester</code> or use an absolute reference for the code above. ex: <code>echo '#!/bin/sh' &gt; /tmp/missing/semester</code>.</p>
							<p class=pinst><i>Note: <code>&gt;</code> rewrites the file while <code>&gt;&gt;</code> add the string to the end of the file.</i></p></li>
					</ol>

				</div>
				
							</li>

			<li>	<p>Try to execute the file, i.e. type the path to the script (<code>./semester</code>) into your shell and press enter. Understand why it doesn’t work by consulting the output of <code>ls</code> (hint: look at the permission bits of the file).</p>
				<div class="instblock">
					<ol>
						<li><div class=code-container><code class=in>./semester</code>
								<button class="copy">Copy</button></div>
						<p class=codehead>Terminal output:</p><code class=out>zsh: permission denied: ./semester</code></li>
						<li><div class=code-container><code class=in>ls -l</code>
								<button class="copy">Copy</button></div>
						<p class=codehead>Terminal outupt:</p><code class=out>-rw-r--r-- 1 root root 61 Sep 21 00:11 semester</code>
						<p class=pinst>Here we can see that the root user has read and write permissions but not execute permissions (<code>-rw-</code>).</p></li>
					</ol>
				</div>
					
			<li>	<p>Run the command by explicitly starting the <code>sh</code> interpreter, and giving it the file <code>semester</code> as the first argument, i.e. <code>sh semester</code>. Why does this work, while <code>./semester</code> didn’t?</p>
				<div class="instblock">
					<ol>
						<li><div class=code-container><code class=in>sh semester</code>
								<button class="copy">Copy</button></div>
						<p class=codehead>Terminal output:</p><pre class="out"><code>HTTP/2 200
server: GitHub.com
content-type: text/html; charset=utf-8
last-modified: Thu, 08 Aug 2024 20:16:01 GMT
access-control-allow-origin: *
etag: "66b52781-205d"
expires: Sat, 21 Sep 2024 05:11:22 GMT
cache-control: max-age=600
x-proxy-cache: MISS
x-github-request-id: AD57:16DB:91AA4E:A2E8A7:66EE5322
accept-ranges: bytes
age: 0
date: Sat, 21 Sep 2024 05:01:22 GMT
via: 1.1 varnish
x-served-by: cache-yul1970032-YUL
x-cache: MISS
x-cache-hits: 0
x-timer: S1726894882.484443,VS0,VE27
vary: Accept-Encoding
x-fastly-request-id: 65ccdb2c25c249620614e7e7db2df9a2b545f6ea
content-length: 8285</code></pre>
						<p class=pinst>The <code>sh</code> command is used to invoke a shell. It then reads the content of the file and executes it. The shell invoked is already executable and running so the script only needs to have read permissions.</p></li>
					</ol>
			</li>

			<li>	<p>Look up the <code>chmod</code> program (e.g. use <code>man chmod</code>).</p></li>

			<li> 	<p>Use <code>chmod</code> to make it possible to run the command <code>./semester</code> rather than having to type <code>sh semester</code>. How does your shell know that the file is supposed to be interpreted using <code>sh</code>? See this page on the <a href="https://en.wikipedia.org/wiki/Shebang_(Unix)" target="_blank">shebang</a> line for more information.</p>
				<div class="inst">
					To add the execution bit to all users:
					<div class=code-container><code class=in>chmod +x semester</code>
					<button class="copy">Copy</button></div>
					<p>or</p>
					To add it only for the root:
					<div class=code-container><code class=in>chmod 744 semester</code>
					<button class="copy">Copy</button></div>
					<p class=pinst>The shell knows how to interpret the file because of the shebang specified at the top of the file (#!/bin/sh).<br><i>Note: you don't need a shebang if you invoke the shell manually using the <code>sh</code> command although it is not recommanded to do so.</i></p>
					
				</div>
			</li>

			<li> 	<p>Use <code>|</code> and <code>&gt;</code> to write the “last modified” date output by <code>semester</code> into a file called <code>last-modified.txt</code> in your home directory.</p>
				<div class="inst"><div class=code-container><code class=in>./semester | head -n4 | tail -n1 &gt; last-modified.txt</code>
						<button class=copy>Copy</button></div></p>
			</li>

			<li>	<p>Write a command that reads out your laptop battery’s power level or your desktop machine’s CPU temperature from <code>/sys</code>. Note: if you’re a macOS user, your OS doesn’t have sysfs, so you can skip this exercise.</p>


				<div class="instblock">
				<ol>
					<li>To read battery power: You might find this <a href="https://www.simplified.guide/linux/view-battery-information" target="_blank">guide</a> useful.
						<div class=code-container><code class=in>cat /sys/class/power_supply/BAT1/capacity</code>
							<button class=copy>Copy</button></div>
						<p class=pinst>Will return a number from 0 to 100</p></li>
					
					<li>Wsl doesn't have cpu temperature in sysfs. However, if you are on linux, 
						<div class=code-container><code class=in>cat /sys/class/thermal/thermal_zone*/temp</code>
						<button class=copy>Copy</button></div>
						should work. You have to look at the <code>type</code> of different thermal zones to find the one associated to the cpu and change the <code>*</code> for the appropriate number.<br><a href="https://www.baeldung.com/linux/cpu-temperature">This guide</a> might help.</li>
				</ol>
				</div>
			</li>

			
	</ol>

<?php include '../partials/lectNav.php'; ?>

<script src='../js/lectureNav.js'></script>
		
<script src='../js/copyButton.js'></script>

</body>
</html>
