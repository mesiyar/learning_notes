package main

import (
	"flag"
	"fmt"
	"io"
	"os"
)

func main() {
	var rst,managerFile, serviceFile, systemFile, dbFile, sDbFile, rFile, sRFile, databaseFile, sDatabaseFile, redisFile, sRedisFile,file,www string
	rst = "E:/y/HealthExam_Standard/.vscode"
	www = "E:/y/HealthExam_Standard"
	managerFile = www + "/wwwroot/manager/config/config.php" // manager 主配置文件
	serviceFile = www + "/wwwroot/service/config/config.php" // service 主配置文件
	systemFile = www + "/system/config/config.php"           // system 主配置文件

	dbFile = rst + "/configs/database.php"          // 本地配置的 manager 数据库配置文件
	sDbFile = rst + "/configs/database_service.php" // 本地配置的 service 数据库配置文件
	//
	rFile = rst + "/configs/redis.php"          // 本地配置的 manager redis配置文件
	sRFile = rst + "/configs/redis_service.php" // 本地配置的 service redis配置文件
	//
	databaseFile = www + "/wwwroot/manager/config/database.php"  // manager 数据库配置文件
	sDatabaseFile = www + "/wwwroot/service/config/database.php" // service 数据库配置文件
	redisFile = www + "/wwwroot/manager/config/redis.php"        // manager redis配置文件
	sRedisFile = www + "/wwwroot/service/config/redis.php"       // service redis配置文件


	var db,cl,ck string
	flag.StringVar(&db, "db", "-", "待切换的数据库")
	flag.StringVar(&cl, "l", "-", "删除日志")
	flag.StringVar(&ck, "ck", "-", "检查配置文件")
	flag.Parse()
	if db != "-" {
		fmt.Printf("切换数据库环境 %s \n", db)
		file = rst + "/configs/database_" + db
		if PathExists(file) {
			if _, err := CopyFile(file, dbFile); err == nil {
				fmt.Println("manager db 切换成功")
			} else {
				fmt.Println("复制出错")
				fmt.Println(err.Error())
				return
			}
			if _, err := CopyFile(dbFile, databaseFile); err == nil {
				fmt.Println("service db 切换成功")
			} else {
				fmt.Println("复制出错")
				fmt.Println(err.Error())
				return
			}
			fmt.Println("切换成功")
		} else {
			fmt.Println("对应db配置文件不存在")
			return
		}
	}

	if cl != "-" {
		fmt.Printf("删除日志文件 \n")
		file = www + "/logs"
		if PathExists(file) {
			err := os.RemoveAll(file)
			if(err != nil) {
				fmt.Printf("清理日志文件失败")
				fmt.Println(err)
			}
		}
	}

	if ck != "-" {
		if PathExists(managerFile) {
			fmt.Println("存在 manager 主配置文件")
		} else {
			bakFile := managerFile + ".bak"
			if _, err := CopyFile(bakFile, managerFile); err == nil {
				fmt.Println("复制 manger 主配置文件 成功")
			} else {
				fmt.Println("复制 manager 出错")
				fmt.Println(err.Error())
			}
		}

		if PathExists(serviceFile) {
			fmt.Println("存在 service 主配置文件")
		} else {
			bakFile := serviceFile + ".bak"
			if _, err := CopyFile(bakFile, serviceFile); err == nil {
				fmt.Println("复制 service 主配置文件 成功")
			} else {
				fmt.Println("复制 service 出错")
				fmt.Println(err.Error())
			}
		}

		if PathExists(systemFile) {
			fmt.Println("存在 system 主配置文件")
		} else {
			bakFile := systemFile + ".bak"
			if _, err := CopyFile(bakFile, systemFile); err == nil {
				fmt.Println("复制 system 主配置文件 成功")
			} else {
				fmt.Println("复制 system 出错")
				fmt.Println(err.Error())
			}
		}

		if PathExists(databaseFile) {
			fmt.Println("存在 database 主配置文件")
		} else {
			if _, err := CopyFile(dbFile, databaseFile); err == nil {
				fmt.Println("复制 database 主配置文件 成功")
			} else {
				fmt.Println("复制 manager database 出错")
				fmt.Println(err.Error())
			}
			if _, err := CopyFile(sDbFile, sDatabaseFile); err == nil {
				fmt.Println("复制 database 主配置文件 成功")
			} else {
				fmt.Println("复制 service database 出错")
				fmt.Println(err.Error())
			}
		}

		if PathExists(redisFile) {
			fmt.Println("存在 redis 主配置文件")
		} else {
			if _, err := CopyFile(rFile, redisFile); err == nil {
				fmt.Println("复制 redis 主配置文件 成功")
			} else {
				fmt.Println("复制 manager redis 出错")
				fmt.Println(err.Error())
			}
			if _, err := CopyFile(sRFile, sRedisFile); err == nil {
				fmt.Println("复制 redis 主配置文件 成功")
			} else {
				fmt.Println("复制 service redis 出错")
				fmt.Println(err.Error())
			}
		}
	}

}

func PathExists(path string) bool {
	_, err := os.Stat(path)
	if err == nil {
		return true
	}
	if os.IsNotExist(err) {
		return false
	}
	return false
}

func CopyFile(srcName, dstName string) (written int64, err error) {
	src, err := os.Open(srcName)
	if err != nil {
		return
	}
	defer src.Close()
	if PathExists(dstName) {
		os.Remove(dstName)
	}
	dst, err := os.OpenFile(dstName, os.O_WRONLY|os.O_CREATE, 0644)
	if err != nil {
		return
	}
	defer dst.Close()
	return io.Copy(dst, src)
}
