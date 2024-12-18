<!DOCTYPE html>
<html>

<head>

<title>'Lecture 5 | Missing Semester Solutions'</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../styles/lecture.css">
</head>

<body class=lecture>

	<h3><a href="https://missing.csail.mit.edu/2020/command-line/" target="_blank">Lecture 5</a></h3>

	<h5 class=lect-title>Job control</h5>
	<ol class=lectlist>
		<li>From what we have seen, we can use some <code>ps aux | grep</code> commands to get our jobs’ pids and then kill them, but there are better ways to do it. Start a <code>sleep 10000</code> job in a terminal, background it with <code>Ctrl-Z</code> and continue its execution with <code>bg</code>. Now use <code><a href='https://www.man7.org/linux/man-pages/man1/pgrep.1.html'>pgrep</a></code> to find its pid and <code><a href='https://man7.org/linux/man-pages/man1/pgrep.1.html' target=_blank>pkill</a></code> to kill it without ever typing the pid itself. (Hint: use the <code>-af</code> flags).
			<div class=inst>
			<div class=code-container><code class="in">pgrep -af sleep</code>
									<button class="copy">Copy</button></div>
			<p class=codehead>Terminal output:</p>
			<code class=out style='margin-bottom: 15px;'>12345 sleep 1000</code><br>
			<div class=code-container><code class="in">pkill -f sleep</code>
									<button class="copy">Copy</button></div>
			</div>
		</li>

		<li>Say you don’t want to start a process until another completes. How would you go about it? In this exercise, our limiting process will always be <code>sleep 60 &</code>. One way to achieve this is to use the <code>wait</code> command. Try launching the <code>sleep</code> command and having an <code>ls</code> wait until the background process finishes.
			<div class=inst>
			<div class=code-container><code class="in">sleep 60 &</code>
									<button class="copy">Copy</button></div>
			<div class=code-container><code class="in">wait $! | ls</code>
									<button class="copy">Copy</button></div>
			<p class=pinst><code>$!</code> refers to the id of the last job. You can change it with the id of another job if you like or use <code>%1</code> to refer to the first job on the list.</p></div>
			
			However, this strategy will fail if we start in a different bash session, since <code>wait</code> only works for child processes. One feature we did not discuss in the notes is that the <code>kill</code> command’s exit status will be zero on success and nonzero otherwise. <code>kill -0</code> does not send a signal but will give a nonzero exit status if the process does not exist. Write a bash function called <code>pidwait</code> that takes a pid and waits until the given process completes. You should use <code>sleep</code> to avoid wasting CPU unnecessarily.

				<div class=inst><div class=code-container><div class=file-cont><p class=codehead>pidwait</p><code 
class=file><pre>
pidwait() {
    local pid="$1"

    # Check if a PID was provided
    if [ -z "$pid" ]; then
        echo "Usage: pidwait <pid>"
        return 1
    fi

    # Loop until the process is no longer running
    while kill -0 "$pid" 2>/dev/null; do
        sleep 1  # Sleep for 1 second to avoid busy waiting
    done

    echo "Process $pid has completed."
}

</pre></code></div>
					<button class=copy>Copy</button></div></div>
			</div>
		</li>
	</ol>


	<h5 class=lect-title>Terminal Multiplexer</h5>
	<ol class=lectlist>
		<li>Follow this <code>tmux</code> <a href='https://www.hamvocke.com/blog/a-quick-and-easy-guide-to-tmux/' target=_blank>tutorial</a> and then learn how to do some basic customizations following <a herf='https://hamvocke.com/blog/a-guide-to-customizing-your-tmux-conf/' target=_blank>these steps</a>.</li>
	</ol>

	<h5 class=lect-title>Aliases</h5>
	<ol class=lectlist>
		<li>Create an alias <code>dc</code> that resolves to <code>cd</code> for when you type it wrongly.
			<div class=inst><div class=code-container><div class=file-cont><p class=codehead>.zshrc</p><code class=file><pre>
alias dc='cd'
</pre></code></div>
					<button class=copy>Copy</button></div></div>
		</li>

		<li>Run <code>history | awk '{$1="";print substr($0,2)}' | sort | uniq -c | sort -n | tail -n 10</code> to get your top 10 most used commands and consider writing shorter aliases for them. Note: this works for Bash; if you’re using ZSH, use <code>history 1</code> instead of just <code>history</code>.</li>
	</ol>

	<h5 class=lect-title>Dotfiles</h5>
	<ol class=lectlist>
		<li>Create a folder for your dotfiles and set up version control.
			<div class=inst>
				You can create a folder in your root directory:
				<div class=code-container><code class="in">mkdir ~/dotfiles</code>
									<button class="copy">Copy</button></div>
				Then you can use <code>Git</code> to set up version control.<br>
				You will see more details on how to use git in the next lecture but if you don't know the basics, here is how to do it:<br><br>
				First you have to install git if you don't already have it.
				<div class=code-container><code class="in">sudo apt-get install git</code>
									<button class="copy">Copy</button></div>
				Then, you can create a <a href='https://github.com/' target=_blank>Github</a> account and create a dotfiles repository.<br>
				After that, download the remote repository on you local machine using:
				<div class=code-container><code class="in">git pull [url of your dotfiles repository]</code>
									<button class="copy">Copy</button></div>
				Copy your dotfiles to your dotfiles directory.<br>
				When you are ready to save the changes you made, add them to the staging area and make a commit:
				<div class=code-container><code class="in">git add -A </code>
									<button class="copy">Copy</button></div>
				<div class=code-container><code class="in">git commit -m 'my first commit!'</code>
									<button class="copy">Copy</button></div>
				<p class=pinst><code>-A</code> adds all files to the staging area, but you can specify each file to add instead<br>
				<code>-m '[message]'</code> Specifies the message associated with the commit</p>
			</div>
		</li>

		<li>Add a configuration for at least one program, e.g. your shell, with some customization (to start off, it can be something as simple as customizing your shell prompt by setting <code>$PS1</code>).
			<div class=inst> You can look at my own <a target=_blank href='https://github.com/simon-bouchard/dotfiles'>dotfiles</a> for some simple configuration example. ChatGPT is also a good tool to find some commonly used configuration.</div>
		</li>

		<li>Set up a method to install your dotfiles quickly (and without manual effort) on a new machine. This can be as simple as a shell script that calls <code>ln -s</code> for each file, or you could use a <a href='https://dotfiles.github.io/utilities/' target=_blank>specialized utility</a>.
			<div class=inst><div class=code-container><div class=file-cont><p class=codehead>machine_init.sh</p><code class=file><pre>
#!/bin/bash

# Install Dotfiles
files="zshrc profile tmux.conf vimrc"

for file in $files; do 
	ln -sf ~/dotfiles/$file ~/.$file

done
</pre></code></div>
					<button class=copy>Copy</button></div>
				You can also setup a script to install zsh, Oh My Zsh! and Zsh plugins
				<div class=code-container><div class=file-cont><p class=codehead>machine_init.sh</p><code class=file><pre>
#Install Zsh and oh-my-zsh

#Zsh
if ! command -v zsh >/dev/null 2>&1; then
    echo "Zsh not found. Installing Zsh..."
    sudo apt update && sudo apt install -y zsh
else
    echo "Zsh is already installed."
fi

#Oh-my-Zsh
if [ ! -d "$HOME/.oh-my-zsh" ]; then
    echo "Installing Oh My Zsh..."
    # Run the Oh My Zsh installation script
    RUNZSH=no sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" --unattended
else
    echo "Oh My Zsh is already installed."
fi

# Install zsh plugins

# Define the Oh My Zsh custom plugin directory
ZSH_CUSTOM="$HOME/.oh-my-zsh/custom"
PLUGIN_DIR="$ZSH_CUSTOM/plugins"
AUTOSUGGESTIONS_REPO="https://github.com/zsh-users/zsh-autosuggestions"
SYNTAX_HIGHLIGHTING_REPO="https://github.com/zsh-users/zsh-syntax-highlighting"
FAST_SYNTAX_HIGHLIGHTING_REPO="https://github.com/zdharma-continuum/fast-syntax-highlighting"
AUTOCOMPLETE_REPO="https://github.com/marlonrichert/zsh-autocomplete"

# Create custom plugins directory if it doesn't exist
mkdir -p "$PLUGIN_DIR"

# Function to install a plugin
install_plugin() {
	local repo_url=$1
	local plugin_name=$2
	local plugin_path="$PLUGIN_DIR/$plugin_name"

	echo "Installing $plugin_name..."
	git clone "$repo_url" "$plugin_path"
}

# Install each plugin
install_plugin "$AUTOSUGGESTIONS_REPO" "zsh-autosuggestions"
install_plugin "$SYNTAX_HIGHLIGHTING_REPO" "zsh-syntax-highlighting"
install_plugin "$FAST_SYNTAX_HIGHLIGHTING_REPO" "fast-syntax-highlighting"
install_plugin "$AUTOCOMPLETE_REPO" "zsh-autocomplete"

echo "Zsh, Oh My Zsh, and Zsh plugins installed!"

# Switch shell to zsh
if [ "$SHELL" != "$(which zsh)" ]; then
    echo "Changing default shell to Zsh..."
    chsh -s $(which zsh)
else
    echo "Default shell is already Zsh."
fi

echo "Installation complete!"</pre></code></div>
					<button class=copy>Copy</button></div>
			<p class=pinst>You should change the <code>ZSH_CUSTOM</code> variable to <code>$HOME/.zsh/custom</code> if you do not use oh my zsh.</p>
		</li>

		<li>Test your installation script on a fresh virtual machine.</li>

		<li>Migrate all of your current tool configurations to your dotfiles repository.</li>

		<li>Publish your dotfiles on GitHub.
			<div class=inst>
				Since we already created the repository in a previous question, all we have to do is
				<div class=code-container><code class="in">git push [URL]</code>
									<button class="copy">Copy</button></div>
			</div>
		</li>

	</ol>

	<h5 class=lect-title>Remote Machines</h5>
	<ol class=lectlist>

		<p>Install a Linux virtual machine (or use an already existing one) for this exercise. If you are not familiar with virtual machines check out <a href='https://hibbard.eu/install-ubuntu-virtual-box/' target=_blank>this</a> tutorial for installing one.</p>
		<li>Go to <code>~/.ssh/</code> and check if you have a pair of SSH keys there. If not, generate them with <code>ssh-keygen -o -a 100 -t ed25519</code>. It is recommended that you use a password and use <code>ssh-agent</code> , more info <a href=https://www.ssh.com/academy/ssh/agent target=_blank>here</a>.</li>

		<li><p>Edit <code>.ssh/config</code> to have an entry as follows</p>
			<div class=instcode><pre>Host vm
	User username_goes_here
	HostName ip_goes_here
	IdentityFile ~/.ssh/id_ed25519
	LocalForward 9999 localhost:8888</pre></div>
		</li>

		<li>Use <code>ssh-copy-id vm</code> to copy your ssh key to the server.</li>

		<li>Start a webserver in your VM by executing <code>python -m http.server 8888</code>. Access the VM webserver by navigating to <code>http://localhost:9999</code> in your machine.
			<div class=inst>
				After starting the server on the vm you should connect your host to the vm with:
				<div class=code-container><code class="in">SSH -L 9999:localhost:8888 vm</code>
									<button class="copy">Copy</button></div>
				After that you can naviguate (on a browser) to <code>http:localhost:9999</code>
				<p class=pinst>You might have to use <code>python3</code> instead of <code>python</code>
				<br>You should create an alias for python3 is that's the case.</p>
		</li>

		<li>Edit your SSH server config by doing <code>sudo vim /etc/ssh/sshd_config</code> and disable password authentication by editing the value of <code>PasswordAuthentication</code>. Disable root login by editing the value of <code>PermitRootLogin</code>. Restart the <code>ssh</code> service with <code>sudo service sshd restart</code>. Try sshing in again.
			<div class=inst><div class=code-container><div class=file-cont><p class=codehead>sshd_config</p><code class=file><pre>
PasswordAuthentification no
PermitRootLogin no</pre></code></div>
					<button class=copy>Copy</button></div>
				<p class=pinst>Disabling password authentification forces users to connect using ssh keys.
				Disabling root logins prevents users from connecting directly as the root. Both increase security.</p></div>
			</li>

			<li>(Challenge) Install <code><a gref='https://mosh.org/' target=_blank>mosh</a></code> in the VM and establish a connection. Then disconnect the network adapter of the server/VM. Can mosh properly recover from it?
				<div class=inst>Install mosh (on both machines):
				<div class=code-container><code class="in">sudo apt-get install mosh</code>
									<button class="copy">Copy</button></div>
				Then, connect to your vm using mosh:
				<div class=code-container><code class="in">mosh vm</code>
									<button class="copy">Copy</button></div>
				<p class=pinst>Disconnect your vm from virtual box and reconnect it again.<br>
				As you can see mosh successfully recovers from it instead of crashing.</p>
			</li>

			<li>(Challenge) Look into what the <code>-N</code> and <code>-f</code> flags do in <code>ssh</code> and figure out a command to achieve background port forwarding.
				<div class=inst> 
					<p>The <code>-N</code> flag tells SSH not to execute any remote commands. It's used when you only want to establish a connection for port forwarding or tunneling, without running any shell or commands on the remote host.</p>
					<p>The <code>-f</code> flag tells SSH to go into the background just before executing the command. When paired with -N, it allows SSH to start the connection, set up the port forwarding, and then run in the background, leaving your terminal free.</p>
					To put it all together:
					<div class=code-container><code class="in">ssh -f -N -L 9999:localhost:8888 vm</code>
									<button class="copy">Copy</button></div>

			</li>

		</ol>

<?php include '../partials/lectNav.php'; ?>

<script src='../js/lectureNav.js'></script>
		
<script src='../js/copyButton.js'></script>


</body>
</html>
