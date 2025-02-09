#!/bin/bash

# Update version number in project files
# (Assuming composer.json for a Laravel project)
# You can add more commands here to update other files if needed

# Commit the changes
git add .
git commit -m "Release version 1.0.0"

# Create a tag for the release
git tag -a v1.0.0 -m "Release version 1.0.0"

# Push the changes and the tag to the remote repository
git push origin main
git push origin v1.0.0
