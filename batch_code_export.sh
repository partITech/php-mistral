#!/bin/bash
### export use in gpt's files.
# Name of the output file prefix
OUTPUT_PREFIX="code_export"
# Directories to process
DIRECTORIES=("src" "tests" "examples/")
# File extensions to include (PHP, YAML, Twig, etc.)
EXTENSIONS=("php" "yaml" "yml" "xml" "twig" "json")

# Function to add a file to the markdown file
append_file_to_output() {
    local file="$1"
    local output="$2"
    file_mime=$(file --mime-type -b "$file" | sed 's|.*/||')
    local file_mime
    local header="## 📄 File: \`$file\`"
    local code_block_open='```'"$file_mime"
    local code_block_close='```'

    {
        echo "$header"
        echo "$code_block_open"
        cat "$file"
        echo "$code_block_close"
        echo ""
    } >> "$output"
}

# Process each directory separately
for dir in "${DIRECTORIES[@]}"; do
    # Create output file for this directory
    OUTPUT="${OUTPUT_PREFIX}_${dir//\//_}.md"
    
    # Initialize the output file
    echo "# 🔍 Source Code Export for this Project - ${dir}" > "$OUTPUT"
    echo "_This file contains source code from the ${dir} directory._" >> "$OUTPUT"
    echo "" >> "$OUTPUT"
    
    # Process files in this directory
    for ext in "${EXTENSIONS[@]}"; do
        find "$dir" -type f -name "*.$ext" | sort | while read -r file; do
            echo "Processing: $file"
            append_file_to_output "$file" "$OUTPUT"
        done
    done
    echo "✅ Code export completed for $dir to $OUTPUT"
done