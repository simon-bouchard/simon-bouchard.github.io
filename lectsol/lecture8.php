<!DOCTYPE html>
<html>

<head>

<title>'Lecture 8 | Missing Semester Solutions'</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../styles/lecture.css">
</head>

<body class=lecture>

	<h3><a href="https://missing.csail.mit.edu/2020/metaprogramming/" target="_blank">Lecture 8</a></h3>
	<ol class=lectlist>

		<li>Most makefiles provide a target called <code>clean</code>. This isn’t intended to produce a file called <code>clean</code>, but instead to clean up any files that can be re-built by make. Think of it as a way to “undo” all of the build steps. Implement a <code>clean</code> target for the <code>paper.pdf</code> <code>Makefile</code> above. You will have to make the target <a href='https://www.gnu.org/software/make/manual/html_node/Phony-Targets.html' target=_blank>phony</a>. You may find the <code><a href='https://git-scm.com/docs/git-ls-files' target=_blnak>git ls-files</a></code> subcommand useful. A number of other very common make targets are listed <a href='https://www.gnu.org/software/make/manual/html_node/Standard-Targets.html#Standard-Targets' target=_blank>here</a>.
			
			<div class=inst>
				<div class=code-container><div class=file-cont><p class=codehead>Makefile</p><code class=file><pre>
paper.pdf: paper.tex plot-data.png
	pdflatex paper.tex

plot-%.png: %.dat plot.py
	./plot.py -i $*.dat -o $@

.PHONY: clean
clean:
rm -f $(shell git ls-files -o --exclude-standard)
</pre></code></div>
					<button class=copy>Copy</button></div>
				<p><code>.PHONY</code> tells make that <code>clean</code> is a command and not a file, ensuring it will be executed everytime.</p>
				<p><code>git ls-files -o</code> returns files that aren't tracked by git (so files created in the <code>make</code> process).
				<br><code>--exclude-standard</code> excludes files that are ignored by git (like in .gitignore_global).</p>
			</div>
		</li>

		<li>Take a look at the various ways to specify version requirements for dependencies in <a href='https://doc.rust-lang.org/cargo/reference/specifying-dependencies.html' target=_blnak>Rust’s build system</a>. Most package repositories support similar syntax. For each one (caret, tilde, wildcard, comparison, and multiple), try to come up with a use-case in which that particular kind of requirement makes sense.
			<div class=instblock>
				<ul>
					<li>Caret (^): Allows updates that don’t break compatibility, common for libraries with semantic versioning.

						<br>Use case: ^1.2.3 allows any 1.x.x greater than 1.2.3.
					</li>
					<li>Tilde (~): Allows updates within a minor version.

						<br>Use case: ~1.2.3 allows updates up to 1.3.x, keeping more control over changes.
					</li>
					<li>Wildcard (*): Allows any version in a certain range.

						<br>Use case: 1.* when you’re flexible about any version within 1.x.x.
					</li>
					<li>Comparison (&gt;=, &lt;, etc.): Specific range constraints.

						<br>Use case: &gt;=1.2.3, &lt;2.0.0 for strict boundaries.
				 	</li>
					<li>Multiple requirements: Combines different rules.

						<br>Use case: &gt;=1.2, &lt;2.0 || &gt;=2.1, &lt;3.0 for handling major version transitions.
					</li>
				</ul>
			</div>
		</li>

		<li>Git can act as a simple CI system all by itself. In <code>.git/hooks</code> inside any git repository, you will find (currently inactive) files that are run as scripts when a particular action happens. Write a <code><aa href='https://git-scm.com/docs/githooks#_pre_commit' target=_blank>pre-commit</a></code> hook that runs <code>make paper.pdf</code> and refuses the commit if the make command fails. This should prevent any commit from having an unbuildable version of the paper.
			<div class=inst>Add the following script to <code>.git/hooks/pre-commit</code>:
				<div class=code-container><div class=file-cont><p class=codehead>pre-commit</p><code class=file><pre>
#!/bin/bash

# Run make to build the paper
if ! make paper.pdf; then
	echo "Build failed. Commit aborted."
    exit 1
fi
</pre></code></div>
					<button class=copy>Copy</button></div>
				Make sure the code is executable with <code>chmod +x .git/hooks/pre-commit</code>
			</div>
		</li>

		<li>Set up a simple auto-published page using <a href='https://pages.github.com/' target=_blank>GitHub Pages</a>. Add a <a href='https://github.com/features/actions' target=_blank>GitHub Action</a> to the repository to run <code>shellcheck</code> on any shell files in that repository (here is <a href='https://github.com/marketplace/actions/shellcheck' target=_blank>one way to do it</a>). Check that it works!
			<div class=inst>
				<p>Create a github repo like [your-github-username].github.io.</p>
				<p>You can modify the page's settings in the <code>Pages</code> option on the side-menu under the settings section.</p>
				Otherwise, create the <code>.github/workflows/shellcheck.yml</code> file and add the following lines:
				<div class=code-container><div class=file-cont><p class=codehead>shellsheck.yml</p><code class=file><pre>
name: Shellcheck

on: [push, pull_request]

jobs:
  shellcheck:
      runs-on: ubuntu-latest

  steps:
      - name: Checkout repository
        uses: actions/checkout@v2

      - name: Run Shellcheck
        uses: ludeeus/action-shellcheck@2.0.0
        with:
	        files: "**/*.sh"
</pre></code></div>
					<button class=copy>Copy</button></div>
				After that, commit and push the file to Github (you might need to update token permissions to allow workflow scope).
			</div>
		</li>

		<li><a href='https://docs.github.com/en/actions/sharing-automations' target=_blank>Build your own</a> GitHub action to run <code><a href='https://github.com/amperser/proselint' target=_blank>proselint</a></code> or <code><a href='https://github.com/btford/write-good' target=_blank>write-good</a></code> on all the <code>.md</code> files in the repository. Enable it in your repository, and check that it works by filing a pull request with a typo in it.
			<div class=instblock>
				<ol><h5>Step 1: Create the action</h5>
					<li>Create the directory for your actions:
						<div class=code-container><code class="in">mkdir -p .github/actions/proselint</code>
									<button class="copy">Copy</button></div>
					</li>
					<li>Create the action file in <code>.github/actions/proselint</code>:
						<div class=code-container><div class=file-cont><p class=codehead>action.yml</p><code class=file><pre>
name: Proselint

description: Run Proselint on markdown files

runs:
  using: "docker"
  image: "Dockerfile"
</pre></code></div>
					<button class=copy>Copy</button></div>
					</li>
					<li>Create the Dockerfile in the same directory:
						<br>This will quickly set up the right environment to execute the action.
						<div class=code-container><div class=file-cont><p class=codehead>Dockerfile</p><code class=file><pre>
FROM python:3.8-slim

RUN pip install proselint

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
</pre></code></div>
							<button class=copy>Copy</button></div>
				</li>
					<li>Create the entrypoint script in the same directory:
						<div class=code-container><div class=file-cont><p class=codehead>entrypoint.sh</p><code class=file><pre>
#!/bin/bash
set -e

# Run proselint on all .md files
for file in $(find . -name '*.md'); do
    echo "Linting $file"
    proselint "$file"
done
</pre></code></div>
							<button class=copy>Copy</button></div>
					</li>
				</ol>
				<ol><h5>Step 2: Create the workflow</h5>
					
					<li>Create the <code>proselint.yml</code> file in the <code>workflows</code> directory you created in the previous question:
						<div class=code-container><div class=file-cont><p class=codehead>entrypoint.sh</p><code class=file><pre>
name: Proselint Check

on:
  pull_request:
    branches:
      - main
  push:
    branches:
	  - main

jobs:
  proselint:
    runs-on: ubuntu-latest

    steps:
    - name: Checkout repository
      uses: actions/checkout@v2

    - name: Run Proselint
      uses: ./.github/actions/proselint
</pre></code></div>
							<button class=copy>Copy</button></div>
					</li>
					<li>Commit and push your new action and workflow files.</li>
					<li>Test it by pushing an md file with errors.</li>
				</ol>
			</div>
		</li>
	</ol>

<?php include '../partials/lectNav.php'; ?>

<script src='../js/lectureNav.js'></script>
		
<script src='../js/copyButton.js'></script>

</body>
</html>
