# Deploying to WordPress.org SVN

When updating the plugin on WordPress.org, ensure the **`languages/`** folder is included so translations work after install/update.

## Add the languages folder to SVN (if missing)

From your **WordPress.org plugin SVN checkout** root (the folder that contains `trunk/`, `tags/`, `branches/`):

```bash
# Go to the plugin SVN root (e.g. intastellar-gdpr-cookie-banner)
cd /path/to/your/svn-checkout/intastellar-gdpr-cookie-banner

# Add the languages folder and all files inside (from trunk)
svn add trunk/languages
svn add trunk/languages/*.pot
svn add trunk/languages/*.po
svn add trunk/languages/*.mo

# Or add everything under languages in one go:
svn add trunk/languages/

# Commit
svn ci -m "Add languages folder with plugin translations (.pot, .po, .mo)"
```

## When creating a new release tag

After updating trunk (including `languages/`), create the tag from trunk so the tag also contains translations:

```bash
svn up
svn cp trunk tags/X.Y.Z
svn ci -m "Tagging version X.Y.Z"
```

Then set **Stable tag** in `trunk/readme.txt` to `X.Y.Z`.

## Plugin page screenshots (WordPress.org landing page)

WordPress.org shows screenshots **only** from the **root-level** `assets/screenshots/` directory (sibling to `trunk/` and `tags/`), not from inside the plugin code.

- **Location:** `assets/screenshots/1.png`, `assets/screenshots/2.png`, etc. (at the SVN repo root).
- **Naming:** Files must be named `1.png`, `2.png`, … to match the numbers in `readme.txt` → `== Screenshots ==`.
- When you update screenshots, copy the final images into **this repo’s** `assets/screenshots/`, then commit that folder to WordPress.org SVN:

```bash
cd /path/to/your/svn-checkout/intastellar-gdpr-cookie-banner
svn add assets/screenshots/
svn add assets/screenshots/*.png
svn ci -m "Update plugin page screenshots"
```

If screenshots don’t update on the plugin page, check that they are in `assets/screenshots/` at the repo root and that you committed that path. Caching can delay updates by a few hours.

## Checklist before each release

- [ ] `trunk/languages/` exists and contains all `.mo` and `.po` files
- [ ] `svn status` shows no unversioned `languages/` files; if it does, run `svn add trunk/languages/`
- [ ] Tag is created from trunk (e.g. `svn cp trunk tags/3.5.3`) so the release ZIP includes `languages/`
- [ ] Plugin page screenshots (if updated) are in **root** `assets/screenshots/` (1.png, 2.png, …) and committed to SVN
