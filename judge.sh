# judge.sh 类似对拍程序。
rm judge # 保险起见，删除上次的可执行文件。
g++ judge.cpp -O2 -o judge # 编译
./judge < data.in > data.out # 运行