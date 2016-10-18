package com.peachtree.wpbapp.activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.widget.Toolbar;
import android.view.MenuItem;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.core.Util;

public class Clinic_Info_Fragment extends DialogFragment{

	private Activity parent;
	private int stackNum;

	public static Clinic_Info_Fragment init(int stackNum){
		Clinic_Info_Fragment fragment = new Clinic_Info_Fragment();

		Bundle args = new Bundle();
		args.putInt("stackNum", stackNum);
		fragment.setArguments(args);

		return fragment;
	}


    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

		stackNum = getArguments().getInt("stackNum");
		parent = getActivity();
    }

}
