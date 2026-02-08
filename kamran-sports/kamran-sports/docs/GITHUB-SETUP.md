# Setting Up GitHub Repository

## 🐙 Quick GitHub Setup

### Step 1: Create Repository on GitHub

1. Go to [GitHub](https://github.com)
2. Click the **"+"** icon → **"New repository"**
3. Fill in:
   - **Repository name:** `kamran-sports`
   - **Description:** "Multi-store retail & eCommerce platform for sports accessories"
   - **Visibility:** Private (recommended) or Public
   - **DO NOT** initialize with README (we already have one)
4. Click **"Create repository"**

### Step 2: Push Your Code to GitHub

Open terminal in your project folder:

```bash
# Initialize git (if not already done)
cd kamran-sports
git init

# Add all files
git add .

# Make first commit
git commit -m "Initial commit: Kamran Sports eCommerce platform setup"

# Add GitHub as remote (replace YOUR_USERNAME with your GitHub username)
git remote add origin https://github.com/YOUR_USERNAME/kamran-sports.git

# Push to GitHub
git branch -M main
git push -u origin main
```

**Enter your GitHub credentials when prompted.**

### Step 3: Verify Upload

1. Go to your repository: `https://github.com/YOUR_USERNAME/kamran-sports`
2. You should see all your files!

---

## 🔑 Using SSH (Recommended)

If you prefer SSH over HTTPS:

### Generate SSH Key

```bash
# Generate new SSH key
ssh-keygen -t ed25519 -C "your_email@example.com"

# Press Enter to accept default location
# Optionally add a passphrase

# Copy the SSH key to clipboard
# On Mac:
cat ~/.ssh/id_ed25519.pub | pbcopy

# On Windows (Git Bash):
cat ~/.ssh/id_ed25519.pub | clip

# On Linux:
cat ~/.ssh/id_ed25519.pub
# Then manually copy the output
```

### Add SSH Key to GitHub

1. Go to GitHub → Settings → SSH and GPG keys
2. Click **"New SSH key"**
3. Paste your key
4. Click **"Add SSH key"**

### Push Using SSH

```bash
# Remove HTTPS remote
git remote remove origin

# Add SSH remote
git remote add origin git@github.com:YOUR_USERNAME/kamran-sports.git

# Push
git push -u origin main
```

---

## 📋 GitHub Repository Settings

### Recommended Settings

1. **Branch Protection** (Settings → Branches):
   - Protect `main` branch
   - Require pull request reviews
   - Require status checks

2. **Collaborators** (Settings → Collaborators):
   - Add team members if any

3. **GitHub Pages** (Optional):
   - Could be used to host frontend later

---

## 🌿 Git Workflow

### Daily Development

```bash
# Before starting work
git pull origin main

# Create a feature branch
git checkout -b feature/user-authentication

# Make changes, then:
git add .
git commit -m "feat: implement user login"

# Push to GitHub
git push origin feature/user-authentication

# Create Pull Request on GitHub
# After review, merge to main
```

### Commit Message Convention

Use clear, descriptive commits:

```bash
git commit -m "feat: add product search functionality"
git commit -m "fix: resolve cart total calculation bug"
git commit -m "docs: update deployment guide"
git commit -m "style: format ProductCard component"
git commit -m "refactor: simplify database query logic"
```

**Prefixes:**
- `feat:` New feature
- `fix:` Bug fix
- `docs:` Documentation
- `style:` Code formatting
- `refactor:` Code restructuring
- `test:` Adding tests
- `chore:` Maintenance tasks

---

## 🔒 Security: What NOT to Commit

Your `.gitignore` already excludes these, but be careful:

❌ **NEVER commit:**
- `config.php` (contains database password)
- `.env` or `.env.local` files
- `node_modules/`
- `vendor/` (if using Composer)
- Database dumps with real customer data
- API keys or secrets
- Upload files in `backend/uploads/` (except .gitkeep)

✅ **DO commit:**
- `config.example.php` (template)
- `.env.example` (template)
- All source code
- Documentation
- Database schema (schema.sql)

---

## 📦 Releases & Tags

When you complete a major milestone:

```bash
# Tag a version
git tag -a v1.0.0 -m "Version 1.0.0: Initial release"

# Push tags to GitHub
git push origin --tags
```

Create a release on GitHub:
1. Go to repository → Releases → Create new release
2. Choose your tag
3. Add release notes
4. Publish

---

## 🔄 Sync with Team Members

If working with others:

```bash
# Get latest changes
git pull origin main

# If you have uncommitted changes
git stash           # Save your changes temporarily
git pull origin main
git stash pop       # Restore your changes
```

---

## 🚨 Trouble? Common Git Issues

### "Failed to push - remote contains work..."

```bash
# Pull first, then push
git pull origin main --rebase
git push origin main
```

### Accidentally committed config.php

```bash
# Remove from git but keep local file
git rm --cached backend/config.php
git commit -m "chore: remove config.php from git"

# Make sure .gitignore includes config.php
echo "config.php" >> backend/.gitignore
git add .gitignore
git commit -m "chore: update gitignore"
git push origin main
```

### Want to undo last commit (but keep changes)

```bash
git reset --soft HEAD~1
```

### Want to completely undo last commit

```bash
git reset --hard HEAD~1
# WARNING: This deletes your changes!
```

---

## 📖 GitHub README Badge Ideas

Add these to your README.md for a professional look:

```markdown
![PHP](https://img.shields.io/badge/PHP-8.0+-blue)
![React](https://img.shields.io/badge/React-18-blue)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-blue)
![License](https://img.shields.io/badge/License-Proprietary-red)
```

---

## ✅ GitHub Setup Checklist

- [ ] GitHub account created/logged in
- [ ] New repository created on GitHub
- [ ] Git initialized locally (`git init`)
- [ ] All files committed (`git commit`)
- [ ] Remote added (`git remote add origin`)
- [ ] Code pushed to GitHub (`git push`)
- [ ] Repository is private/public as intended
- [ ] .gitignore is working (no config.php or node_modules)
- [ ] README.md displays nicely on GitHub

---

**Your code is now safely backed up on GitHub! 🎉**

Remember to:
- Commit frequently
- Write clear commit messages
- Push to GitHub regularly
- Never commit sensitive data

Happy coding! 🚀
