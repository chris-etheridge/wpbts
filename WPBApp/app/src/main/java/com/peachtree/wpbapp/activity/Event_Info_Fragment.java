package com.peachtree.wpbapp.activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.os.Bundle;

public class Event_Info_Fragment extends DialogFragment
{

	private Activity parent;
	private int stackNum;

	public static Event_Info_Fragment init(int stackNum){
		Event_Info_Fragment fragment = new Event_Info_Fragment();

		Bundle args = new Bundle();
		args.putInt("stackNum", stackNum);
		fragment.setArguments(args);

		return fragment;
	}
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }
}
