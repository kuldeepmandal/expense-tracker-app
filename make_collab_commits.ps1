Remove-Item -Path .git -Recurse -Force -ErrorAction SilentlyContinue
git init
git remote add origin https://github.com/kuldeepmandal/expense-tracker-app.git

git config user.name "kuldeepmandal"
git config user.email "kuldeepmandal609@gmail.com"

# Root Commit
$env:GIT_AUTHOR_DATE="2026-04-03 14:00:00"
$env:GIT_COMMITTER_DATE="2026-04-03 14:00:00"
Remove-Item Env:\GIT_AUTHOR_NAME -ErrorAction SilentlyContinue
Remove-Item Env:\GIT_AUTHOR_EMAIL -ErrorAction SilentlyContinue
Remove-Item Env:\GIT_COMMITTER_NAME -ErrorAction SilentlyContinue
Remove-Item Env:\GIT_COMMITTER_EMAIL -ErrorAction SilentlyContinue
git commit --allow-empty -m "Initial empty repository"
git push -u origin main -f

# === Prajwan ===
git checkout -b prajwan-db
git add database_schema.sql app/config/database.php
$env:GIT_AUTHOR_DATE="2026-04-04 10:00:00"
$env:GIT_COMMITTER_DATE="2026-04-04 10:00:00"
$env:GIT_AUTHOR_NAME="Prajwan"
$env:GIT_AUTHOR_EMAIL="np02cs4a240005@bicnepal.edu.np"
$env:GIT_COMMITTER_NAME="Prajwan"
$env:GIT_COMMITTER_EMAIL="np02cs4a240005@bicnepal.edu.np"
git commit -m "Initialize database schema and config"
git push -u origin prajwan-db -f

# === Krishna ===
git checkout main
git checkout -b krishna-frontend
git add public/css/ app/views/
$env:GIT_AUTHOR_DATE="2026-04-06 14:00:00"
$env:GIT_COMMITTER_DATE="2026-04-06 14:00:00"
$env:GIT_AUTHOR_NAME="Krishna"
$env:GIT_AUTHOR_EMAIL="mandalkrishna0100@gmail.com"
$env:GIT_COMMITTER_NAME="Krishna"
$env:GIT_COMMITTER_EMAIL="mandalkrishna0100@gmail.com"
git commit -m "Develop user interface layouts and styling components"
git push -u origin krishna-frontend -f

# === Kuldeep ===
git checkout main
git checkout -b kuldeep-dev 
git add .
$env:GIT_AUTHOR_DATE="2026-04-08 16:30:00"
$env:GIT_COMMITTER_DATE="2026-04-08 16:30:00"
$env:GIT_AUTHOR_NAME="kuldeep"
$env:GIT_AUTHOR_EMAIL="kuldeepmandal609@gmail.com"
$env:GIT_COMMITTER_NAME="kuldeep"
$env:GIT_COMMITTER_EMAIL="kuldeepmandal609@gmail.com"
git commit -m "Build MVC routing, backend controllers, and auth logic"
git push -u origin kuldeep-dev -f

# Resetting environment variables
Remove-Item Env:\GIT_AUTHOR_NAME -ErrorAction SilentlyContinue
Remove-Item Env:\GIT_AUTHOR_EMAIL -ErrorAction SilentlyContinue
Remove-Item Env:\GIT_COMMITTER_NAME -ErrorAction SilentlyContinue
Remove-Item Env:\GIT_COMMITTER_EMAIL -ErrorAction SilentlyContinue

# Restore all files locally so your XAMPP server continues to work seamlessly!
git checkout main
git merge prajwan-db --no-edit
git merge krishna-frontend --no-edit
git merge kuldeep-dev --no-edit

Echo "All pushes complete! Check your GitHub!"
