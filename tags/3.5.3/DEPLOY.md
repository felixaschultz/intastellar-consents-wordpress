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

## Checklist before each release

- [ ] `trunk/languages/` exists and contains all `.mo` and `.po` files
- [ ] `svn status` shows no unversioned `languages/` files; if it does, run `svn add trunk/languages/`
- [ ] Tag is created from trunk (e.g. `svn cp trunk tags/3.5.3`) so the release ZIP includes `languages/`
