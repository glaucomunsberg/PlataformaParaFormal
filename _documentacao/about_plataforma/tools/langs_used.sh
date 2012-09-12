#!/bin/bash

VERBOSE=false
GENERATE=false

if test "$1" = "-h" -o "$1" = "--help"
then
    echo "Usage: `basename "$0"` [-h|--help] [-v|--verbose] [MODULE_FOLDERNAME]"
    exit 0
fi
if test "$1" = "-v" -o "$1" = "--verbose"
then
    VERBOSE=true
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

# process $* as a line of langfile and test if this lang is used or not
process(){
    local line line_out line_split term_delim term loc_delim loc found
    
    line="$*"
    
    line_split="${line%%'='*}"
    line_split=`echo "${line_split##*'['}"`
    term_delim="${line_split:0:1}"
    term="`echo "$line_split" | cut -d "$term_delim" -f 2`"
    
    line_split=`echo ${line##*'='}`
    loc_delim="${line_split:0:1}"
    loc="`echo "$line_split" | cut -d "$loc_delim" -f 2`"
    
    found=`mktemp -qu`
    
    while ! test -e "$found"
    do
        find controllers -name '*.php' |
            while read php
            do
                if cat "$php" | grep "$term"
                then
                    echo >> "$found"
                    break
                fi
            done
        find models -name '*.php' |
            while read php
            do
                if cat "$php" | grep "$term"
                then
                    echo >> "$found"
                    break
                fi
            done
        find views -name '*.php' |
            while read php
            do
                if cat "$php" | grep ."$term"
                then
                    echo >> "$found"
                    break
                fi
            done
        break
    done
    
    line_out="\e[34;1m${line//\'$term\'/\e[m\e[33m'$term'\e[m\e[34;1m}"
    line_out="${line_out//\'$loc\'/\e[m\e[33m'$loc'\e[m\e[34;1m}\e[m"
    
    if ! test -e "$found"
    then
        echo -e "$line_out \e[33;41;1m// not used\e[m"
        rm -f "$found"
        echo
        return 1
    elif $VERBOSE
    then
        echo -e "$line_out"
        return 1
    fi
    return 0
}


echo "Processing langs, the langs unused will be reported"


cat "language/pt-br/${module}_labels_lang.php" |
    grep '$lang' |
    while read line
    do
        result="`process "$line"`"
        test "$?" = "0" ||
            echo -e "$result"
    done 2>&1

cat "language/pt-br/${module}_messages_lang.php" |
    grep '$lang' |
    while read line
    do
        message="`process "$line"`"
        test "$?" = "0" ||
            echo -e "$message"
    done 2>&1









