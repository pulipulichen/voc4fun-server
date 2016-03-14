# INFORMATION
#
# 1. cp root_update_kals.sh ~/
# 2. chmod 700 root_update_kals.sh
# 3. Modify KALS_PATH and BRANCH
# 4. ~/root_update_kals.sh

KALS_PATH=/opt/lampp/htdocs/voc4fun-server
export KALS_PATH
KALS_BRANCH=origin/master
export KALS_BRANCH
KALS_DIR=/opt/lampp/htdocs
export KALS_DIR

chmod 700 "$KALS_PATH"/git-scripts/*.sh
"$KALS_PATH"/git-scripts/update.sh
