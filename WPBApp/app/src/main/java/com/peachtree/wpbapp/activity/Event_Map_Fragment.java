package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.os.Bundle;

public class Event_Map_Fragment extends DialogFragment {

	private Activity parent;
	private int stackNum;

	public static Event_Map_Fragment init(int stackNum){
		Event_Map_Fragment fragment = new Event_Map_Fragment();

		Bundle args = new Bundle();
		args.putInt("stackNum", stackNum);
		fragment.setArguments(args);

		return fragment;
	}

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

		parent = getActivity();
		stackNum = getArguments().getInt("stackNum");

    }
}
