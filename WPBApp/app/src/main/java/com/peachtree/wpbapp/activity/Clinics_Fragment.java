package com.peachtree.wpbapp.activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.MenuItem;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.core.Util;

public class Clinics_Fragment extends DialogFragment
{
	private Activity parent;
	private int stackNum;

	public static Clinics_Fragment init(int stackNum){

		Clinics_Fragment fragment = new Clinics_Fragment();

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
