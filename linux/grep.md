### grep
```bash
#在./下递归查找 xxx的字符
grep -r "xxx" ./*
# 不区分大小写 -i
grep -ri "xxx" ./*
# 返回行数 -n
grep -rni "xxx" ./*
# 只显示匹配的字符 -o
grep -rno "xxx" ./*
# -A -B 前一行 后一行
grep -r -A1 -B1 "xxx" ./*
# -w 包含指定字符
grep -r -w "xxx" ./*
# -v 不包含某个字符
grep -v "xxx" ./*
# 匹配多个目标
grep -e "xxx" -e "yyy" ./*



```