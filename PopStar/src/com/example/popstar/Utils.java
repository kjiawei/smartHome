package com.example.popstar;

public class Utils {
	public static String array2str(int[][] arg) {
		String b="";
		for(int i=0;i<10;i++){
			for(int j=0;j<10;j++){
				b = b + arg[i][j];
			}
		}
		return b;
		
	}
	
	public static int[][] str2array(String arg) {
		int[][] a = new int[10][10];
		for(int i=0;i<10;i++){
			for(int j=0;j<10;j++){
				char c = arg.charAt(i*10+j);
				a[i][j]= Integer.parseInt(c+"");
			}
		}
		return a;
		
	}

}
