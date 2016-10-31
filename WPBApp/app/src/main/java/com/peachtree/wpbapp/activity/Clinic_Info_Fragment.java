package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.content.Context;
import android.os.Bundle;
import android.view.Display;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.WindowManager;
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
	private float mCurrenty;

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

		mCurrenty = view.getY();
		final float originalY = mCurrenty;

		if(clinic != null){

		}else{
			/* To be implemented once test data available.
			Toast.makeText(getActivity(), "Could Not Load Event.", Toast.LENGTH_SHORT);
			dismiss();
			*/
		}

		view.findViewById(R.id.pull_grip).setOnTouchListener(new View.OnTouchListener()
		{
			private float offset;

			@Override
			public boolean onTouch(View v, MotionEvent event)
			{
				int action = event.getAction();
				if(action == MotionEvent.ACTION_DOWN){
					offset= mCurrenty - event.getRawY();
				}else if(action == MotionEvent.ACTION_MOVE){
					mCurrenty = (int)(event.getRawY() + offset);
					if(mCurrenty > originalY)
					{
						view.setY(mCurrenty);
					}
				}else if(action == MotionEvent.ACTION_UP){

					if(mCurrenty > originalY + 1000){
						dismiss();
					}else{
						mCurrenty = originalY;
						view.setY(mCurrenty);
					}
				}
				return true;
			}
		});

		return view;
	}

	@Override
	public void onStart(){
		super.onStart();
		WindowManager wm = (WindowManager)parent.getSystemService(Context.WINDOW_SERVICE);
		Display display = wm.getDefaultDisplay();
		getDialog().getWindow().setBackgroundDrawable(null);
		getDialog().getWindow().setLayout(display.getWidth() - 50, display.getHeight() - 50);
	}

	private void load_event(){
		//TO-DO
	}
}
