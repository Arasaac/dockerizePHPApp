<?php
// $Header: /cvsroot/html2ps/box.table.row.php,v 1.18 2005/10/06 03:55:16 Konstantin Exp $

class TableRowBoxPDF extends GenericContainerBoxPDF {
  var $rows;
  var $colspans;
  var $rowspans;

  function &create($pdf, &$root) {
    $box =& new TableRowBoxPDF();

    $child = $root->first_child();
    while ($child) {
      $child_box =& create_pdf_box($pdf, $child);
      $box->add_child($child_box);

      $child = $child->next_sibling();
    };

    return $box;
  }

  function add_child(&$item) {
    if (is_a($item, "TableCellBoxPDF")) {
      GenericContainerBoxPDF::add_child($item);
    };
  }

  function TableRowBoxPDF() {
    // Call parent constructor
    $this->GenericContainerBoxPDF();

//     // Initialize line box
//     $this->_current_x = 0;
//     $this->_current_y = 0;

//     // Initialize content
//     $this->content = array();
  }

  // Normalize colspans by adding fake cells after the "colspanned" cell
  // Say, if we've got the following row:
  // <tr><td colspan="3">1</td><td>2</td></tr>
  // we should get row containing four cells after normalization;
  // first contains "1"
  // second and third are completely empty
  // fourth contains "2"
  function normalize() {
    for ($i=0; $i<count($this->content); $i++) {
      for ($j=1; $j<$this->content[$i]->colspan; $j++) {
        $this->add_fake_cell_after($i);
      };
    };
  }

  function add_fake_cell_after($index) {
    array_splice($this->content, $index+1, 0, array(new FakeTableCellBoxPDF));
  }

  function add_fake_cell_before($index) {
    array_splice($this->content, $index, 0, array(new FakeTableCellBoxPDF));
  }

  function append_fake_cell() {
    $this->content[] = new FakeTableCellBoxPDF;
  }

  // Inherited from GenericBoxPDF
//   function get_min_width(&$context) {
//     return array_sum($this->get_table_columns_min_widths($context));
//   }

//   function get_max_width(&$context) {
//     return array_sum($this->get_table_columns_max_widths($context));
//   }

  // Table specific

  function table_resize_row($height, $top) {
    // Do cell vertical-align
    // Calculate row baseline 

    $baseline = $this->get_row_baseline();   

    // Process cells contained in current row
    for ($i=0; $i<count($this->content); $i++) {
      $cell =& $this->content[$i];

      // Offset cell if needed
      $cell->offset(0, 
                    $top - 
                    $cell->get_top_margin());

      // Vertical-align cell (do not apply to rowspans)
      if ($cell->rowspan == 1) {
        $va_fun = CSSVerticalAlign::value2pdf($cell->vertical_align);
        $va_fun->apply_cell($cell, $height, $baseline);

        // Expand cell to full row height
        $cell->put_full_height($height);
      }
    }
  }

  function get_row_baseline() {
    $baseline = 0;
    for ($i=0; $i<count($this->content); $i++) {
      $baseline = max($baseline,$this->content[$i]->get_cell_baseline());
    }
    return $baseline;
  }

  function get_colspans($row_index) {
    $colspans = array();

    for ($i=0; $i<count($this->content); $i++) {
      // Check if current colspan will run off the right table edge
      if ($this->content[$i]->colspan > 1) {
        $colspan = new CellSpan;
        $colspan->row = $row_index;
        $colspan->column = $i;
        $colspan->size = $this->content[$i]->colspan;

        $colspans[] = $colspan;
      }
    }

    return $colspans;
  }

  function get_rowspans($row_index) {
    $spans = array();

    for ($i=0; $i<count($this->content); $i++) {
      if ($this->content[$i]->rowspan > 1) {
        $rowspan = new CellSpan;
        $rowspan->row = $row_index;
        $rowspan->column = $i;
        $rowspan->size = $this->content[$i]->rowspan;
        $spans[] = $rowspan;
      }
    }

    return $spans;
  }

  // Column widths
  function get_table_columns_max_widths(&$context) {
    $widths = array();
    for ($i=0; $i<count($this->content); $i++) {
      // For now, colspans are treated as zero-width; they affect 
      // column widths only in parent *_fit function
      if ($this->content[$i]->colspan > 1) {
        $widths[] = 0;        
      } else {
        $widths[] = $this->content[$i]->get_max_width($context);
      }
    }
    return $widths;
  }

  function get_table_columns_min_widths(&$context) {
    $widths = array();
    for ($i=0; $i<count($this->content); $i++) {
      // For now, colspans are treated as zero-width; they affect 
      // column widths only in parent *_fit function
      if ($this->content[$i]->colspan > 1) {
        $widths[] = 0;        
      } else {
        $widths[] = $this->content[$i]->get_min_width($context);
      };
    }
    return $widths;
  }

  function get_table_columns_xxx_widths(&$context, $fun) {
    $widths = array();
    for ($i=0; $i<count($this->content); $i++) {
      // For now, colspans are treated as zero-width; they affect 
      // column widths only in parent *_fit function
      if ($this->content[$i]->colspan > 1) {
        $widths[] = 0;        
      } else {
        $widths[] = $this->content[$i]->get_max_width($context);
      }
    }
    return $widths;
  }

  function row_height() {
    // Calculate height of each cell contained in this row
    $height = 0;
    for ($i=0; $i<count($this->content); $i++) {
      if ($this->content[$i]->rowspan <= 1) {
        $height = max($height, $this->content[$i]->get_full_height());
      }
    }

    return $height;
  }

  // Note that we SHOULD owerride the show method inherited from GenericContainerBox, 
  // as it MAY draw row background in case it was set via CSS rules. As row box 
  // is a "fake" box and will never have reasonable size and/or position in the layout,
  // we should prevent this
  function show(&$viewport) {
    // draw content
    for ($i=0; $i < count($this->content); $i++) {
      // We'll check the visibility property here
      // Reason: all boxes (except the top-level one) are contained in some other box, 
      // so every box will pass this check. The alternative is to add this check into every
      // box class show member.
      //
      // The only exception of absolute positioned block boxes which are drawn separately;
      // their show method is called explicitly; the similar check should be performed there
      // 
      if ($this->content[$i]->visibility === VISIBILITY_VISIBLE) {
        $this->content[$i]->show($viewport);
      };
    }
  }
  
  function to_ps(&$psdata) {
    $psdata->write("box-table-row-create\n");
    $this->to_ps_common($psdata);
    $this->to_ps_css($psdata);
    $this->to_ps_content($psdata);
    $psdata->write("add-child\n");
  }

  // Flow-control
}
?>