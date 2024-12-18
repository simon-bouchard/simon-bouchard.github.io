<!DOCTYPE html>
<html>

<head>

<title>'Lecture 6 | Missing Semester Solutions'</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../styles/lecture.css">
</head>

<body class=lecture>

	<h3><a href="https://missing.csail.mit.edu/2020/version-control/" target="_blank">Lecture 6</a></h3>
	<ol class=lectlist>
		<li>If you don’t have any past experience with Git, either try reading the first couple chapters of <a href='https://git-scm.com/book/en/v2' target=_blank>Pro Git</a> or go through a tutorial like <a href='https://learngitbranching.js.org/?locale=fr_FR' target=_blank>Learn Git Branching</a>. As you’re working through it, relate Git commands to the data model.</li>

		<li style='margin-bottom: 0;'>Clone the <a href='https://github.com/missing-semester/missing-semester' target=_blank>repository for the class website</a>.
			<div class=inst><div class=code-container><code class="in">git clone https://github.com/missing-semester/missing-semester class_website</code>
									<button class="copy">Copy</button></div></div>

			<ol class=inner-list>
				<li>Explore the version history by visualizing it as a graph.
					<div class=inst><div class=code-container><code class="in">git log --all --graph</code>
									<button class="copy">Copy</button></div></div>
				</li>
				<li>Who was the last person to modify <code>README.md</code>? (Hint: use <code>git log</code> with an argument).
					<div class=inst><div class=code-container><code class="in">git log --all --graph README.md</code>
									<button class="copy">Copy</button></div></div>
				</li>
				<li>What was the commit message associated with the last modification to the <code>collections:</code> line of <code>_config.yml</code>? (Hint: use <code>git blame</code> and <code>git show</code>).
					<div class=inst><div class=code-container><code class="in">git blame _config.yml</code>
									<button class="copy">Copy</button></div>
						<p class=pinst>Hash of the collections: line last modification is a88b4eac.</p>
					<div class=code-container><code class="in"> git show a88b4eac</code>
									<button class="copy">Copy</button></div>
						<p class=pinst>The message is "Redo lectures as a collection"</p>
				</li>
			</ol>
		</li>

		<li>One common mistake when learning Git is to commit large files that should not be managed by Git or adding sensitive information. Try adding a file to a repository, making some commits and then deleting that file from history (you may want to look at <a herf='https://docs.github.com/fr/authentication/keeping-your-account-and-data-secure/removing-sensitive-data-from-a-repository' target=_blank>this</a>).
			<div class=inst><div class=code-container><code class="in">bfg --delete-files YOUR-FILE-WITH-SENSITIVE-DATA</code>
									<button class="copy">Copy</button></div>
				If you also want to clean the remote repository:
			<div class=code-container><code class="in">git push --force</code>
				<button class="copy">Copy</button></div></div>
		</li>

		<li>Clone some repository from GitHub, and modify one of its existing files. What happens when you do <code>git stash</code>? What do you see when running <code>git log --all --oneline</code>? Run <code>git stash pop</code> to undo what you did with <code>git stash</code>. In what scenario might this be useful?
			<div class=inst>
				Running git stash stores the modifications you made and reverts the working directory to the latest commit (no change). <code>git log --all --oneline</code> Won't show the stashed changes because they are stored seperately. <code>git stash pop</code> will revert the working tree back to before <code>git stash</code>.<br>
				This is useful to quickly see what changes you made since the last commit and to write the right commit message. Also it allows you to change branches without having to commit your work or to pull new changes from remote repository without conflictig with local changes.
			</div>
		</li>

		<li>Like many command line tools, Git provides a configuration file (or dotfile) called <code>~/.gitconfig</code>. Create an alias in <code>~/.gitconfig</code> so that when you run git graph, you get the output of <code>git log --all --graph --decorate --oneline</code>. You can do this by directly <a href='https://git-scm.com/docs/git-config#Documentation/git-config.txt-alias' target=_blank>editing</a> the <code>~/.gitconfig</code> file, or you can use the <code>git config</code> command to add the alias. Information about git aliases can be found <a href='https://git-scm.com/book/en/v2/Git-Basics-Git-Aliases' target=_blank>here</a>.
			<div class=inst>
				<div class=code-container><code class="in">vim ~/.gitconfig</code>
				<button class="copy">Copy</button></div>
				<div class=code-container><div class=file-cont><p class=codehead>boot_time.sh</p><code class=file><pre>
[alias]
	graph = log --all --graph --decorate --online
						</pre></code></div>
					<button class=copy>Copy</button></div></div>
		</li>

		<li>You can define global ignore patterns in <code>~/.gitignore_global</code> after running <code>git config --global core.excludesfile ~/.gitignore_global</code>. Do this, and set up your global gitignore file to ignore OS-specific or editor-specific temporary files, like <code>.DS_Store</code>.
			<div class=inst>
				Here are some examples of files you might want to ignore:
				<div class=code-container><div class=file-cont><p class=codehead>gitignore_globa</p><code class=file><pre>
# Ignore zone identifier files (WSL)
*Zone.Identifier

# Ignore vim swap and backup files
*.swp
*.swo
*.swn

*.bak
*.backup

# Sensitive SSH and GPG files
.ssh/
id_rsa
id_rsa.pub
known_hosts

.gnupg/						</pre></code></div>
					<button class=copy>Copy</button></div></div>
		</li>

		<li>Fork the repository for the class website, find a typo or some other improvement you can make, and submit a pull request on GitHub (you may want to look at <a href='https://github.com/firstcontributions/first-contributions'>this</a>). Please only submit PRs that are useful (don’t spam us, please!). If you can’t find an improvement to make, you can skip this exercise.
			<div class=inst><p>The class website has few improvements left to make so you can do this exercise with <a href='https://github.com/simon-bouchard/simon-bouchard.github.io' target=_blank>this website's repository</a> (the site you are currently on). <br>
				This site still has a lot of improvements to make so you don't have any excuse to skip this exercise. This will also give you an opportunity to practice vim.</p>
				<p>If you don't know what to do, you can make the the html files xhtml compatible (especially quotations), add/remove whitespace (both in the files and the website) and add comments to make it more readable, rephrase some of the text so it doesn't look like I was having a stroke when writing it (English is my second language) or add explanations to the exercises I was to lazy to explain completely.</p>
				If I accept your changes, you will also be granted the enormous honor of having your name listed in the contributions section from the about page no one ever looks at!
			</div>
		</li>

	</ol>

<?php include '../partials/lectNav.php'; ?>

<script src='../js/lectureNav.js'></script>
		
<script src='../js/copyButton.js'></script>


</body>
</html>
