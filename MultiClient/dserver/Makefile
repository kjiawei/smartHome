CC = gcc
CFLAGS = -O2 -Wall 
DB_OBJS = main.o thread.o credis.o ini.o servernet.o setting.o loadbalance.o
CFLAGS = -O2

dserver: $(DB_OBJS)
	$(CC) $(CFLAGS) -o $@ $(DB_OBJS) -lpthread ./deps/hiredis/libhiredis.a

clean:
	rm -rf *.o dserver
