package com.example.popstar;

public class Node {
	public int row;
	public int col;
	
	public Node(int row, int col) {
		this.row = row;
		this.col = col;
	}

	public boolean equals(Object o) {
		Node node = (Node) o;
		return row==node.row && col==node.col;
	}
}
