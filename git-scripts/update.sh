if [ -z "$KALS_BRANCH" ]; then KALS_BRANCH=voc4fun-server;/master; fi
if [ -z "$KALS_DIR" ]; then KALS_DIR=/opt/lampp/htdocs; fi
if [ -z "$KALS_PATH" ]; then KALS_PATH=/opt/lampp/htdocs/voc4fun-server; fi

#echo $KALS_PATH
if [ -d "$KALS_PATH" ]; then
    clone.sh
fi
cd $KALS_PATH
git --git-dir="$KALS_PATH"/.git clean -f -d
git --git-dir="$KALS_PATH"/.git reset --hard "$KALS_BRANCH"
#git --git-dir="$KALS_PATH"/.git pull --rebase --force kals
git --git-dir="$KALS_PATH"/.git pull --force kals

git --git-dir="$KALS_PATH"/.git merge "$KALS_BRANCH" --no-commit

