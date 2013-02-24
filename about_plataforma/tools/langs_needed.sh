#!/bin/bash

VERBOSE=false
GENERATE=false

if test "$1" = "-h" -o "$1" = "--help"
then
    echo "Usage: `basename "$0"` [-h|--help] [-v|--verbose] [MODULE_FOLDERNAME]" # [-a|--auto-generate]"
    exit 0
fi
if test "$1" = "-v" -o "$1" = "--verbose"
then
    VERBOSE=true
fi
if test "$1" = "-a" -o "$1" = "--auto-generate"
then
    GENERATE=true
fi

cd "`dirname $0`/.."

if test -e "$1"
then
    module="$1"
else
    echo -n "Which module?? "
    read module
    test -e "$module" || module=exemplo_app
fi

cd "$module"

# process $term and return $loc and $choice
generate_lang(){
    loc=""
    echo -n "What translation to use for term '$term'?? " >&2
    read loc
    choice=""
    while test "$choice" != 'label' -a "$choice" != 'message'
    do
        echo -n "'$term' is label or message?? " >&2
        read choice
    done
}

# process $* as php and read its lines finding "lang('...')" entries
process_file(){
    local n fail php line_final line_end line_init term_delim term find loc
    n=$'\n'
    fail="`mktemp -qu`"
    
    php="$*"
    
    echo "\n\n\e[42;1m$php:\e[m"
    cat "$php" |
        grep 'lang' |
        grep '(' |
        while read line
        do
            line_final="$line"
            line_end=`echo "${line##*'lang'}"`
            line_init=`echo "${line%$line_end}"`
            
            
            while test "$line_init" != "${line_init//lang/}"
            do
                if test "${line_end:0:1}" = "("
                then
                    line_end="`echo "${line_end#(}"`"
                    term_delim="${line_end:0:1}"
                    term="`echo "$line_end" | cut -d "$term_delim" -f 2`"
                    line_final="${line_final//$term/\e[31;1m$term\e[m}"
                    
                    find=`cat "language/pt-br/${module}_labels_lang.php" \
                            "language/pt-br/${module}_messages_lang.php" \
                            "../system/language/pt-br/system_lang.php" \
                            2>/dev/null |
                            grep '$lang' | grep "$term['\"]"`

                    if test "$find"
                    then
                        find="\e[46m${find//$term/\e[42;1m$term\e[m\e[46m}\e[m"
                    else
                        loc=""
                        if $GENERATE && false
                        then
                            generate_lang
                            echo "\$lang[\e[31;1m'$term'\e[m] = \e[31;1m'$loc'\e[m;" #>> "language/pt-br/${module}_${choice}s_lang.php"
                        fi
                        if $VERBOSE
                        then
                            find="${line//$term/\e[31;1m$term\e[m}\n\e[41;1mTerm '$term' not translated!\e[m"
                        else
                            find="\e[34;1m\$lang[\e[m\e[33m'$term'\e[m\e[34;1m] = \e[m\e[33m'$loc'\e[m\e[34;1m;\e[m"
                        fi
                        echo "$find" >> "$fail"
                    fi
                fi
                line_init="${line_init%'lang'}"
                line_end=`echo "${line_init##*'lang'}"`
                line_init=`echo "${line_init%$line_end}"`
            done
            
            #echo "$line_final\n$find"
        done
    if test -e "$fail"
    then
        cat "$fail"
        rm -f "$fail"
        return 1
    else
        return 0
    fi
}




echo "Finding langs that have no internacionalization done"


(
    find controllers -name '*.php'
    find models -name '*.php'
    find views -name '*.php'
) | while read php;
    do
        result="`process_file "$php"`"
        if test "$?" != "0"
        then
            echo -en "$result"
        fi
    done




echo







