package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.Core.Util;
import com.peachtree.wpbapp.Entities.Clinic;
import com.peachtree.wpbapp.Entities.Event;

public class Clinic_Info_Fragment extends DialogFragment
{

	private Activity parent;
	private int id;
	private Clinic clinic;

	public static Clinic_Info_Fragment init(int id){
		Clinic_Info_Fragment fragment = new Clinic_Info_Fragment();

		Bundle args = new Bundle();
		args.putInt("id", id);
		fragment.setArguments(args);

		return fragment;
	}
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
		parent = getActivity();
		id = getArguments().getInt("id");
		load_event();
    }

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState){
		super.onCreateView(inflater, container, savedInstanceState);
		View view = inflater.inflate(R.layout.clinic_info_layout, container, false);

		if(clinic != null){

		}else{
			/* To be implemented once test data available.
			Toast.makeText(getActivity(), "Could Not Load Event.", Toast.LENGTH_SHORT);
			dismiss();
			*/
		}

		return view;
	}

	@Override
	public void onStart(){
		super.onStart();
		getDialog().getWindow().setLayout(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.MATCH_PARENT);
	}

	private void load_event(){
		//TO-DO
	}
}
