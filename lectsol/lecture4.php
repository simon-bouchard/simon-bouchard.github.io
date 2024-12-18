<!DOCTYPE html>
<html>

<head>

<title>'Lecture 4 | Missing Semester Solutions'</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../styles/lecture.css">
</head>

<body class=lecture>

	<h3><a href="https://missing.csail.mit.edu/2020/data-wrangling/" target="_blank">Lecture 4</a></h3>
	<ol class=lectlist>
		<li><p>Take this <a href='https://regexone.com/' target='_blank'>short interactive regex tutorial</a></p></li>

		<li><p>Find the number of words (in <code>/usr/share/dict/words</code>) that contain at least three <code>a</code>s and don’t have a <code>'s</code> ending. What are the three most common last two letters of those words? <code>sed</code>’s <code>y</code> command, or the <code>tr</code> program, may help you with case insensitivity. How many of those two-letter combinations are there? And for a challenge: which combinations do not occur?</p>
							<div class="inst">

								If <code>cat /usr/share/dict/words</code> doesn't return anything, you can install with:
								<div class=code-container><code class="in">sudo apt install wamerican</code>
									<button class="copy">Copy</button></div></div>
							<div class=instblock>
								<ol>
									<li>Find the number of words with 3 a's that don't end with 's.
									<div class=code-container><code class="in">grep -iE '^[^aA]*[aA][^aA]*[aA][^aA]*[aA]' /usr/share/dict/words | grep -v "'s$" | tr '[:upper:]' '[:lower:]' | wc -l</code>
										<button class="copy">Copy</button></div></li>

									<li>What are the three most common last two letters of those words?
									<div class=code-container><code class="in">grep -iE '^[^aA]*[aA][^aA]*[aA][^aA]*[aA]' /usr/share/dict/words | grep -v "'s$" | tr '[:upper:]' '[:lower:]' | sed 's/.*\(..\)$/\1/' | sort | uniq -c | sort -nr | head -n 3</code>
										<button class="copy">Copy</button></div></li>

  									<li>How many of those two words combinations are there?
									<div class=code-container><code class="in">grep -iE '^[^aA]*[aA][^aA]*[aA][^aA]*[aA]' /usr/share/dict/words | grep -v "'s$" | tr '[:upper:]' '[:lower:]' | sed 's/.*\(..\)$/\1/' | sort | uniq | wc -l</code>
										<button class="copy">Copy</button></div></li>

									<li>Which combinations do not occur?<br><br>First we need to generate all two letter combinations.
										<div class=code-container><code class="in">echo {a..z}{a..z} | tr ' ' '\n' | sort > all_combinations.txt</code>
										<button class="copy">Copy</button></div>
									Then, we find the endings of words with three a's that don't end in 's.
									<div class=code-container><code class="in">grep -iE '^[^aA]*[aA][^aA]*[aA][^aA]*[aA]' /usr/share/dict/words | grep -v "'s$" | tr '[:upper:]' '[:lower:]' | sed 's/.*\(..\)$/\1/' | sort | uniq > existing combinations</code>
										<button class="copy">Copy</button></div>
									Then to find which line differ:
									<div class=code-container><code class="in">diff --new-file --suppress-common-lines all_combinations.txt existing_combinations.txt | grep '&gt;' | sed 's/&gt; //'</code>
										<button class="copy">Copy</button></div>
									<div class=pint><p><code>diff --suppress-common-lines</code> Shows what lines are present in both files</p>
										<p><code>grep '&gt;'</code> Selects lines starting with <code>&gt;</code>, so the lines present only in the first file.</p>
										<p><code>sed 's/&gt; //'</code> Removes the leading <code>&gt;</code> character and the space that follows.</p>

							</li>

					</ol>

				</li>


				<li>To do in-place substitution it is quite tempting to do something like <code>sed s/REGEX/SUBSTITUTION/ input.txt > input.txt</code>. However this is a bad idea, why? Is this particular to <code>sed</code>? Use <code>man sed</code> to find out how to accomplish this.
				<div class=inst>
					<p>sed will overwrite the file before it finishes writing the file.</p>
					<p>Instead you can use the inplace argument <code>-i</code> like so <code>sed -i 's/REGEX/SUBSTITUTION/' input.txt</code>.</p></div>
				</li>

				<li>Find your average, median, and max system boot time over the last ten boots. Use journalctl on Linux and log show on macOS, and look for log timestamps near the beginning and end of each boot. On Linux, they may look something like:<br>
					<div class=instcode>Logs begin at ...</div>
					<p>and</p>
					<div class=instcode>systemd[577]: Startup finished in ...</div>
					<div class=inst>
						<p>If your system supports the <code>-b</code> option on <code>systemd analyze</code> you can use that to get the time of each boot easily.</p>
						Otherwise, this script will work:
						<div class=code-container><div class=file-cont><p class=codehead>boot_time.sh</p><code class=file><pre>
#!/bin/bash

# Script to calculate average, median, and max boot times for the last 10 boots

boot_times=()

for i in {-0..-9}; do
  echo "Boot $i:"
  
  # Get the first kernel message for the start of the boot
  start=$(journalctl --boot $i --grep "kernel" | head -n 1 | awk '{print $1, $2, $3}')
  
  # Get the "Reached target Multi-User System" message for the end of the boot
  end=$(journalctl --boot $i --grep "Reached target Multi-User System" | head -n 1 | awk '{print $1, $2, $3}')
  
  echo "Start time: $start"
  echo "End time: $end"
  
  # Calculate time difference if both start and end times are found
  if [[ -n "$start" && -n "$end" ]]; then
    start_ts=$(date -d "$start" +%s)
    end_ts=$(date -d "$end" +%s)
    boot_time=$((end_ts - start_ts))
    echo "Boot time: $boot_time seconds"
    
    # Add boot time to array
    boot_times+=($boot_time)
  else
    echo "Could not find boot time."
  fi
  echo "------------------"
done

# Calculate and display average, median, and max boot times

if [[ ${#boot_times[@]} -gt 0 ]]; then
  # Sort boot times for median calculation
  sorted_times=($(printf '%s\n' "${boot_times[@]}" | sort -n))

  # Calculate average
  total=0
  for time in "${boot_times[@]}"; do
    total=$((total + time))
  done
  average=$((total / ${#boot_times[@]}))

  # Calculate median
  mid_index=$(( ${#sorted_times[@]} / 2 ))
  if (( ${#sorted_times[@]} % 2 == 0 )); then
    median=$(( (sorted_times[mid_index-1] + sorted_times[mid_index]) / 2 ))
  else
    median=${sorted_times[$mid_index]}
  fi

  # Calculate max
  max=${sorted_times[-1]}

  # Display the results
  echo "Average boot time: $average seconds"
  echo "Median boot time: $median seconds"
  echo "Max boot time: $max seconds"
else
  echo "No boot times found."
fi
</pre></code></div>
<button class=copy>Copy</button></div></div>

				</li>
				<li>Look for boot messages that are not shared between your past three reboots (see <code>journalctl</code>’s <code>-b</code> flag). Break this task down into multiple steps. First, find a way to get just the logs from the past three boots. There may be an applicable flag on the tool you use to extract the boot logs, or you can use <code>sed '0,/STRING/d'</code> to remove all lines previous to one that matches <code>STRING</code>. Next, remove any parts of the line that always varies (like the timestamp). Then, de-duplicate the input lines and keep a count of each one (<code>uniq</code> is your friend). And finally, eliminate any line whose count is 3 (since it was shared among all the boots).
							<div class=inst><div class=code-container><div class=file-cont><p class=codehead>diff_boots.sh</p><code class=file><pre>
#!/bin/bash

# Get logs from the last three boots
journalctl --boot -0 &gt; boot_logs_0.txt
journalctl --boot -1 &gt; boot_logs_1.txt
journalctl --boot -2 &gt; boot_logs_2.txt

# Remove the timestamp and keep only the log message
sed 's/^[^ ]* [^ ]* [^ ]* //' boot_logs_*.txt &gt; cleaned_logs.txt

# Sort the cleaned logs and count occurrences
sort cleaned_logs.txt | uniq -c &gt; counted_logs.txt

# Filter out lines with a count of 3
awk '$1 != 3 {print substr($0, 3)}' counted_logs.txt &gt; unique_boot_messages.txt

echo "Unique boot messages that were not shared among the last three boots are stored in unique_boot_messages.txt"</pre></code></div>
<button class=copy>Copy</button></div></div>
			</li>

			<li>Find an online data set like <a href='https://stats.wikimedia.org/EN/TablesWikipediaZZ.htm' target=_blank>this one</a>, <a href='https://ucr.fbi.gov/crime-in-the-u.s/2016/crime-in-the-u.s.-2016/topic-pages/tables/table-1' target=_blank>this one</a>, or maybe one <a target=_blank href='https://www.springboard.com/blog/data-science/free-public-data-sets-data-science-project/'>from here</a>. Fetch it using <code>curl</code> and extract out just two columns of numerical data. If you’re fetching HTML data, <code><a href='https://github.com/EricChiang/pup' target=_blank>pup</a></code> might be helpful. For JSON data, try <code><a href='https://jqlang.github.io/jq/' target=_blank>jq</a></code>. Find the min and max of one column in a single command, and the difference of the sum of each column in another.
							<div class=instblock>
								<ol>
									<li>First you need to install pup if you don't already have it
										<div class=code-container><code class=in>sudo apt-get install pup</code>
											<button class="copy">Copy</button></div></li>

									<li>Fetch the data with curl and put it in a file so you only have to do it once.
										<div class=code-container><code class=in>curl -s https://stats.wikimedia.org/EN/TablesWikipediaZZ.htm -o wikimedia_data.html</code>
											<button class="copy">Copy</button></div></li>

									<li>Then, to get the min and max:
										<div class=code-container><code class=in>pup 'table:nth-of-type(1) tr td:nth-of-type(3) text{}' &lt; wikimedia_data.html | grep -Eo '[0-9]+' | sort -n | awk 'NR==1{print "Min:", $1} END{print "Max:", $1}'</code>
											<button class="copy">Copy</button></div>
										<p class=pinst><code>pup</code> takes the 3rd column of the first table, grep filters out none digits (remove whitespace), <code>sort -n</code> sorts the results to get min and max. <code>awk</code> prints the first (min) and last (max) lines (values).</li>
									
									<li>And for the difference of the sum of each column
										<div class=code-container><code class=in>echo "Difference of Sums: $(echo "$(pup 'table:nth-of-type(1) tr td:nth-of-type(3) text{}' &lt; wikimedia_data.html | grep -Eo '[0-9]+' | paste -sd+ - | bc) - $(pup 'table:nth-of-type(1) tr td:nth-of-type(4) text{}' &lt; wikimedia_data.html | grep -Eo '[0-9]+' | paste -sd+ - | bc)" | bc)"</code>
											<button class="copy">Copy</button></div></li>
									<p class=pinst>This command clalculates the sum of each column inside the parenthesis and then substracts them. </p>
									<p class=pinst>Inside the parenthesis, you should already know what pup and grep do from the last step. <code>paste -sd+ -</code> is used to concatenate all lines into a single line (<code>-s</code> option). <code>-d+</code> separates each value by a <code>+</code> operator. The <code>-</code> is used to make to standard output of the last command into the standard input of this one.</p>
									<p class=pinst>Finally <code>bc</code> transform the string into a mathematical operation.</p>

								</ol>
							</div>
					</li>

		</ol>

<?php include '../partials/lectNav.php'; ?>

<script src='../js/lectureNav.js'></script>
		
<script src='../js/copyButton.js'></script>

</body>
</html>
