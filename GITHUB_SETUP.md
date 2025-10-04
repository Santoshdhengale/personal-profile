# 🚀 GitHub Setup Commands

## After creating your GitHub repository, run these commands:

### 1. Add GitHub repository as remote (replace with your actual URL)
```bash
git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPOSITORY_NAME.git
```

### 2. Rename branch to main (already done)
```bash
git branch -M main
```

### 3. Push to GitHub
```bash
git push -u origin main
```

## 📋 Example with actual repository:
If your GitHub username is "santosh123" and repository name is "portfolio-website":

```bash
git remote add origin https://github.com/santosh123/portfolio-website.git
git push -u origin main
```

## 🔐 Authentication Options:

### Option 1: HTTPS (will prompt for username/password)
- Use your GitHub username
- Use a Personal Access Token as password (not your regular password)

### Option 2: SSH (requires SSH key setup)
- URL format: git@github.com:USERNAME/REPOSITORY.git

## 📝 Quick Steps Summary:
1. Create repository on GitHub.com
2. Copy the repository URL
3. Run: git remote add origin [YOUR_URL]
4. Run: git push -u origin main

## 🎯 Your Project Files Ready to Push:
- ✅ index.html (Portfolio homepage)
- ✅ CSS/JS files (Styling and functionality)
- ✅ PHP files (Contact form backend)
- ✅ README.md (Complete documentation)
- ✅ .gitignore (Proper exclusions)

## 🚀 After Successful Push:
Your portfolio will be available at:
- Repository: https://github.com/YOUR_USERNAME/YOUR_REPOSITORY_NAME
- GitHub Pages: https://YOUR_USERNAME.github.io/YOUR_REPOSITORY_NAME (if enabled)