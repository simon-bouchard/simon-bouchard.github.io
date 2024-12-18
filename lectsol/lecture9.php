<!DOCTYPE html>
<html>

<head>

<title>'Lecture 9 | Missing Semester Solutions'</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../styles/lecture.css">
</head>

<body class=lecture>

	<h3><a href="https://missing.csail.mit.edu/2020/security/" target="_blank">Lecture 9</a></h3>
	<ol class=lectlist>
		<li><h6>Entropy</h6>
			<ol class=inner-list>
				<li>Suppose a password is chosen as a concatenation of four lower-case dictionary words, where each word is selected uniformly at random from a dictionary of size 100,000. An example of such a password is <code>correcthorsebatterystaple</code>. How many bits of entropy does this have?
					<div class=sub-inst>
						If we assume the way to generate the password is known by the potential hacker, there are 10 000^4 = 10^20 combinations possible. Since the entropy is of a password is equal to the logarythm base two of the number of possibilities, we can see that this password generator has log<sub>2</sub>(10<sup>20</sup>) = 66.44 bits of entropy.
					</div>
				</li>

				<li>Consider an alternative scheme where a password is chosen as a sequence of 8 random alphanumeric characters (including both lower-case and upper-case letters). An example is <code>rg8Ql34g</code>. How many bits of entropy does this have?
					<p class=sub-inst>The number of possiblities is equal to (26 * 2 + 10)^8 = 62^8. The entropy is then equal to log<sub>2</sub>(62<sup>8</sup> = 47.63 bits of entropy.</p>
				</li>

				<li>Which is the stronger password?
					<p class=sub-inst>The first password is stronger and is also easier to memorize.</p>
				</li>

				<li>Suppose an attacker can try guessing 10,000 passwords per second. On average, how long will it take to break each of the passwords?
					<div class=sub-inst>
						<p>Case 1: 10^20 possibilities / 10 000 passwords/second = 10^16 seconds / 86400 seconds/day = 1.15 * 10^11 days / 365 days/year = 317 097 919.83764 years to gues all the passwords so 158 548 959.91882 years on average to guess the password.<p>
						<p>Case 2: 62^8 possibilities / 10 000 passwords/second = 2.1834 * 10^10 seconds / 86 400 seconds/day = 252 708.45554 days / 365 days/year = 692.35193 years to guess all the passwords so 346.17597 years on average to guess the password.</p>
					</div>
				</li>
			</ol>
		</li>

		<li><h6>Cryptographic hash functions</h6>
			Download a Debian image from a <a href='https://www.debian.org/CD/http-ftp/' target=_blank>mirror</a> (e.g. <a href='http://debian.xfree.com.ar/debian-cd/current/amd64/iso-cd/' target=_blank>from this Argentinean mirror</a>). Cross-check the hash (e.g. using the <code>sha256sum</code> command) with the hash retrieved from the official Debian site (e.g. <a href='https://cdimage.debian.org/debian-cd/current/amd64/iso-cd/SHA256SUMS' target=_blank>this file</a> hosted at <code>debian.org</code>, if you’ve downloaded the linked file from the Argentinean mirror).
			<div class=instblock>
				<ol>
					<li>Download the debian iso from the mirror:
						<div class=code-container><code class="in">wget http://debian.xfree.com.ar/debian-cd/current/amd64/iso-cd/debian-12.X.X-amd64-netinst.iso</code>
										<button class="copy">Copy</button></div>
					</li>
					<li>Retrieve the official SHA256SUM from the debian website:
						<div class=code-container><code class="in">wget https://cdimage.debian.org/debian-cd/current/amd64/iso-cd/SHA256SUMS</code>
									<button class="copy">Copy</button></div>
					</li>
					<li>Calculate the SHA-256 Hash of the downloaded ISO:
						<div class=code-container><code class="in">sha256sum debian-12.X.X-amd64-netinst.iso</code>
										<button class="copy">Copy</button></div>
					</li>
					<li>Cross-check the hash:
						<div class=code-container><code class="in">sha256sum -c SHA256SUMS 2&gt;&1 | grep debian-12.X.X-amd64-netinst.iso</code>
										<button class="copy">Copy</button></div>
						<p>If you see 'OK' as an output everything went fine, if not...</p>
					</li>
				</ol>
			</div>
		</li>

		<li><h6>Symmetric cryptography</h6>
			Encrypt a file with AES encryption, using <a href='https://www.openssl.org/' target=_blank>OpenSSL</a>: <code>openssl aes-256-cbc -salt -in {input filename} -out {output filename}</code>. Look at the contents using <code>cat</code> or <code>hexdump</code>. Decrypt it with <code>openssl aes-256-cbc -d -in {input filename} -out {output filename}</code> and confirm that the contents match the original using <code>cmp</code>.
			<div class=instblock>
				<ol>
					<li>Encrypt the file:
							<div class=code-container><code class="in">openssl aes-256-cbc -salt -in original_file.txt -out encrypted_file.enc</code>
										<button class="copy">Copy</button></div>					
					</li>
					<li>Check the contents of the encrypted file:
							<div class=code-container><code class="in">hexdump -C encrypted_file.enc</code>
										<button class="copy">Copy</button></div>					
					</li>
					<li>Decrypt the file:
							<div class=code-container><code class="in">openssl aes-256-cbc -d -in encrypted_file.enc -out decrypted_file.txt</code>
										<button class="copy">Copy</button></div>					
					</li>
					<li>Confirm the contents match:
							<div class=code-container><code class="in">cmp original_file.txt decrypted_file.txt</code>
										<button class="copy">Copy</button></div>					
					</li>
				</ol>
			</div>
		</li>

		<li><h6>Asymetric cryptography</h6>
			<ol class=inner-inst>
				<li>Set up <a href='https://www.digitalocean.com/community/tutorials/how-to-set-up-ssh-keys-2' target=_blank>SSH keys</a> on a computer you have access to (not Athena, because Kerberos interacts weirdly with SSH keys). Make sure your private key is encrypted with a passphrase, so it is protected at rest.
					<div class=sub-inst>
						<div class=code-container><code class="in">ssh-keygen -t ed2551</code>
							<button class="copy">Copy</button></div>					
						<p>Be sure to enter a passphrase when prompted and don't write it down on your computer.</p>
					</div>
				</li>

				<li><a href='https://www.digitalocean.com/community/tutorials/how-to-use-gpg-to-encrypt-and-sign-messages' target=_blank>Set up GPG</a>
					<div class=sub-inst>Follow the tutorial linked in the lecture.</div>
				</li>
				
				<li>Send Anish an encrypted email (<a href='https://keybase.io/anish' target=_blank>Public key</a>).
					<div class=sub-inst>You can encrypt a file you for someone if you already have their public keys configured:
						<div class=code-container><code class="in">gpg --encrypt --sign --armor -r person@email.com file_to_encrypt</code>
							<button class="copy">Copy</button></div>

				</li>

				<li>Sign a Git commit with <code>git commit -S</code> or create a signed Git tag with <code>git tag -s</code>. Verify the signature on the commit with <code>git show --show-signature</code> or on the tag with <code>git tag -v</code>.
					<div class=sub-inst>Configure git to use your GPG key (replace <code>ABCDEF1234567890</code> with your key ID and replace <code>user</code> with your git username if it's still not configured)
						<div class=code-container><code class="in">git config --global user.signingkey ABCDEF1234567890</code>
							<button class="copy">Copy</button></div>										
						Sign a git commit:
						<div class=code-container><code class="in">git commit -S -m "Your commit message"</code>
							<button class="copy">Copy</button></div>
						Verify the commit signature:
						<div class=code-container><code class="in">git show --show-signature</code>
							<button class="copy">Copy</button></div>
						Create a signed tag:
						<div class=code-container><code class="in">git tag -s v1.0 -m "Version 1.0 release"</code>
							<button class="copy">Copy</button></div>
						Verify the signature on the tag:
						<div class=code-container><code class="in">git tag -v v1.0</code>
							<button class="copy">Copy</button></div>
					</div>
				</li>
			</ol>
		</li>
	</ol>

<?php include '../partials/lectNav.php'; ?>

<script src='../js/lectureNav.js'></script>
		
<script src='../js/copyButton.js'></script>

</body>
</html>
